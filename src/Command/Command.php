<?php

/**
 * Platine Console
 *
 * Platine Console is a powerful library with support of custom
 * style to build command line interface applications
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2020 Platine Console
 * Copyright (c) 2017-2020 Jitendra Adhikari
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

/**
 *  @file Command.php
 *
 *  The Command class
 *
 *  @package    Platine\Console\Command
 *  @author Platine Developers Team
 *  @copyright  Copyright (c) 2020
 *  @license    http://opensource.org/licenses/MIT  MIT License
 *  @link   http://www.iacademy.cf
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Console\Command;

use Platine\Console\Application;
use Platine\Console\Exception\InvalidParameterException;
use Platine\Console\Exception\RuntimeException;
use Platine\Console\Input\Argument;
use Platine\Console\Input\Option;
use Platine\Console\Input\Parser;
use Platine\Console\IO\Interactor;
use Platine\Console\Output\Writer;
use Platine\Console\Util\Helper;
use Platine\Console\Util\OutputHelper;

/**
 * Class Command
 * @package Platine\Console\Command
 */
class Command extends Parser
{

    /**
     * The command version
     * @var string
     */
    protected string $version = '';

    /**
     * The command name
     * @var string
     */
    protected string $name;

    /**
     * The command description
     * @var string
     */
    protected string $description = '';

    /**
     * The command usage example
     * @var string
     */
    protected string $usage = '';

    /**
     * The command alias
     * @var string
     */
    protected string $alias = '';

    /**
     * The Application instance
     * @var Application|null
     */
    protected ?Application $app = null;

    /**
     * The options events
     * @var array<callable>
     */
    protected array $events = [];

    /**
     * Whether to allow unknown (not registered) options
     * @var bool
     */
    protected bool $allowUnknown = false;

    /**
     * If the last seen argument was variadic
     * @var bool
     */
    protected bool $argVariadic = false;

    /**
     * The verbosity level
     * @var int
     */
    protected int $verbosity = 0;

    /**
     * Create new instance
     * @param string $name
     * @param string $description
     * @param bool $allowUnknown
     * @param Application|null $app
     */
    public function __construct(
        string $name,
        string $description = '',
        bool $allowUnknown = false,
        ?Application $app = null
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->allowUnknown = $allowUnknown;
        $this->app = $app;

        $this->defaults();
    }

    /**
     * Return the version of this command
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Set the command version
     * @param string $version
     * @return $this
     */
    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Return the command name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the command name
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Return the command description
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the command description
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Return the application instance
     * @return Application|null
     */
    public function getApp(): ?Application
    {
        return $this->app;
    }

    /**
     * Bind to given application
     * @param Application|null $app
     * @return $this
     */
    public function bind(?Application $app): self
    {
        $this->app = $app;

        return $this;
    }

    /**
     * Return the command usage
     * @return string
     */
    public function getUsage(): string
    {
        return $this->usage;
    }

    /**
     * Set the command usage
     * @param string $usage
     * @return $this
     */
    public function setUsage(string $usage): self
    {
        $this->usage = $usage;

        return $this;
    }

    /**
     * Return the command alias
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * Set the command alias
     * @param string $alias
     * @return $this
     */
    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Sets event handler for last (or given) option.
     * @param callable $callback
     * @param string|null $option
     * @return $this
     */
    public function on(callable $callback, ?string $option = null): self
    {
        $names = array_keys($this->options());
        $this->events[$option ? $option : end($names)] = $callback;

        return $this;
    }

    /**
     * Register exit handler.
     * @param callable $callback
     * @return $this
     */
    public function onExit(callable $callback): self
    {
        $this->events['_exit'] = $callback;

        return $this;
    }

    /**
     * Add command option
     * @param string $raw
     * @param string $description
     * @param mixed $default
     * @param bool $required
     * @param bool $optional
     * @param bool $variadic
     * @param callable|null $filter
     * @return $this
     */
    public function addOption(
        string $raw,
        string $description,
        $default = null,
        bool $required = false,
        bool $optional = false,
        bool $variadic = false,
        ?callable $filter = null
    ): self {
        $option = new Option(
            $raw,
            $description,
            $default,
            $required,
            $optional,
            $variadic,
            $filter
        );
        $this->register($option);

        return $this;
    }

    /**
     * Add command argument
     * @param string $raw
     * @param string $description
     * @param mixed $default
     * @param bool $required
     * @param bool $optional
     * @param bool $variadic
     * @param callable|null $filter
     * @return $this
     */
    public function addArgument(
        string $raw,
        string $description = '',
        $default = null,
        bool $required = false,
        bool $optional = false,
        bool $variadic = false,
        ?callable $filter = null
    ): self {
        $argument = new Argument(
            $raw,
            $description,
            $default,
            $required,
            $optional,
            $variadic,
            $filter
        );

        if ($this->argVariadic) {
            throw new InvalidParameterException('Only last argument can be variadic');
        }

        if ($argument->isVariadic()) {
            $this->argVariadic = true;
        }

        $this->register($argument);

        return $this;
    }

    /**
     * Return all command options (i.e without defaults).
     * @return array<Option>
     */
    public function commandOptions(): array
    {
        $options = $this->options;

        unset(
            $this->options['help'],
            $this->options['version'],
            $this->options['verbosity'],
        );

        return $options;
    }

    /**
     * Show this command help and abort
     * @return mixed
     */
    public function showHelp()
    {
        $io = $this->io();
        $helper = new OutputHelper($io->writer());

        $io->writer()
            ->bold(
                sprintf(
                    'Command %s, version %s',
                    $this->name,
                    $this->version
                ),
                true
            )->eol();

        $io->writer()
                ->dim($this->description, true)->eol();

        $io->writer()
            ->bold(
                'Usage: '
            );

        $io->writer()
            ->yellow(
                sprintf('%s [OPTIONS...] [ARGUMENTS...]', $this->name),
                true
            );

        $helper->showArgumentsHelp($this->arguments())
                ->showOptionsHelp(
                    $this->options(),
                    '',
                    'Legend: <required> [optional] variadic...'
                );

        if ($this->usage) {
            $helper->showUsage($this->usage, $this->name);
        }

        return $this->emit('_exit', 0);
    }

    /**
     * Show this command version and abort
     * @return mixed
     */
    public function showVersion()
    {
        $this->writer()->bold(
            sprintf(
                '%s, %s',
                $this->name,
                $this->version
            ),
            true
        );

        return $this->emit('_exit', 0);
    }

    /**
     * Execute the command
     * @return mixed
     */
    public function execute()
    {
    }


    /**
     * Performs user interaction if required to set some missing values.
     * @param Interactor $io
     * @return void
     */
    public function interact(Interactor $io): void
    {
    }

    /**
     * Tap return given object or if that is null then app instance.
     * This aids for chaining.
     * @param mixed $object
     * @return mixed
     */
    public function tap($object)
    {
        return $object ? $object : $this->app;
    }

    /**
     * {@inheritdoc}
     */
    public function emit(string $event, $value = null)
    {
        if (empty($this->events[$event])) {
            return null;
        }

        return ($this->events[$event])($value);
    }

    /**
     * Return the value of the given option
     * @param string $longName
     * @return mixed|null
     */
    public function getOptionValue(string $longName)
    {
        $values = $this->values();

        return array_key_exists($longName, $values)
                    ? $values[$longName]
                    : null;
    }

    /**
     * Return the value of the given argument
     * @param string $name
     * @return mixed|null
     */
    public function getArgumentValue(string $name)
    {
        $values = $this->values();

        return array_key_exists($name, $values)
                    ? $values[$name]
                    : null;
    }

    /**
     * Return the input/output instance
     * @return Interactor
     */
    protected function io(): Interactor
    {
        if ($this->app !== null) {
            return $this->app->io();
        }

        return new Interactor();
    }

    /**
     * Return the writer instance
     * @return Writer
     */
    protected function writer(): Writer
    {
        return $this->io()->writer();
    }

    /**
     * {@inheritdoc}
     */
    protected function handleUnknown(string $arg, $value = null)
    {
        if ($this->allowUnknown) {
            return $this->set(Helper::toCamelCase($arg), $value);
        }

        $values = array_filter($this->values(false));

        // Has some value, error!
        if (!empty($values)) {
            throw new RuntimeException(sprintf(
                'Unknown option [%s]',
                $arg
            ));
        }

        // Has no value, show help!
        return $this->showHelp();
    }

    /**
     * Sets default options and exit handler.
     * @return $this
     */
    protected function defaults(): self
    {
        $this->addOption('-h|--help', 'Show help')
              ->on([$this, 'showHelp']);

        $this->addOption('-v|--version', 'Show version')
             ->on([$this, 'showVersion']);

        $this->addOption('-V|--verbosity', 'Verbosity level', 0)
             ->on(function () {
                $this->set('verbosity', $this->verbosity++);

                return false;
             });

        $this->onExit(function (int $exitCode = 0) {
            exit($exitCode);
        });

        return $this;
    }
}
