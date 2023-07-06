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
 *  @file Application.php
 *
 *  The console Application class
 *
 *  @package    Platine\Console
 *  @author Platine Developers Team
 *  @copyright  Copyright (c) 2020
 *  @license    http://opensource.org/licenses/MIT  MIT License
 *  @link   http://www.iacademy.cf
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Console;

use Platine\Console\Command\Command;
use Platine\Console\Exception\ConsoleException;
use Platine\Console\Exception\InvalidArgumentException;
use Platine\Console\IO\Interactor;
use Platine\Console\Util\OutputHelper;
use Throwable;

/**
 * Class Application
 * @package Platine\Console
 */
class Application
{
    /**
     * List of commands
     * @var array<Command>
     */
    protected array $commands = [];

    /**
     * Raw input arguments send to parser
     * @var array<int, string>
     */
    protected array $argv = [];

    /**
     * The commands aliases
     * @var array<string, string>
     */
    protected array $aliases = [];

    /**
     * The name of application
     * @var string
     */
    protected string $name;

    /**
     * The application version
     * @var string
     */
    protected string $version = '';

    /**
     * The application logo using ASCII text
     * @var string
     */
    protected string $logo = '';

    /**
     * The default command to use if none is provided
     * @var string
     */
    protected string $default = '__default__';

    /**
     * The input/output instance
     * @var Interactor|null
     */
    protected ?Interactor $io = null;

    /**
     * The callable to perform exit
     * @var callable
     */
    protected $onExit;

    public function __construct(
        string $name,
        string $version = '1.0.0',
        ?callable $onExit = null
    ) {
        $this->name = $name;
        $this->version = $version;

        $this->onExit = $onExit ? $onExit : function (int $exitCode = 0) {
            //@codeCoverageIgnoreStart
            exit($exitCode);
            //@codeCoverageIgnoreEnd
        };

        $this->command('__default__', 'Default command', '', true, true)
              ->on([$this, 'showHelp'], 'help');
    }

    /**
     * Return the list of command
     * @return array<Command>
     */
    public function getCommands(): array
    {
        $commands = $this->commands;

        unset($commands['__default__']);

        return $commands;
    }

    /**
     * Return the command line argument
     * @return array<int,string>
     */
    public function argv(): array
    {
        return $this->argv;
    }

    /**
     * Return the application name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Return the application version
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Return the application logo
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * Set application logo
     * @param string $logo
     * @return $this
     */
    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }


    /**
     * Add a command by it's name, alias
     * @param string $name
     * @param string $description
     * @param string $alias
     * @param bool $allowUnknown
     * @param bool $default
     * @return Command
     */
    public function command(
        string $name,
        string $description = '',
        string $alias = '',
        bool $allowUnknown = false,
        bool $default = false
    ): Command {
        $command = new Command($name, $description, $allowUnknown, $this);

        $this->addCommand($command, $alias, $default);

        return $command;
    }

    /**
     * Add new command
     * @param Command $command
     * @param string $alias
     * @param bool $default
     * @return $this
     */
    public function addCommand(
        Command $command,
        string $alias = '',
        bool $default = false
    ): self {
        $name = $command->getName();

        if (
            isset($this->commands[$name])
            ||  isset($this->commands[$alias])
            ||  isset($this->aliases[$name])
            ||  isset($this->aliases[$alias])
        ) {
            throw new InvalidArgumentException(sprintf(
                'Command %s already added',
                $name
            ));
        }

        if (empty($alias) && !empty($command->getAlias())) {
            $alias = $command->getAlias();
        }

        if ($alias) {
            $command->setAlias($alias);
            $this->aliases[$alias] = $name;
        }

        if ($default) {
            $this->default = $name;
        }

        $this->commands[$name] = $command
                                    ->setVersion($this->version)
                                    ->onExit($this->onExit)
                                    ->bind($this);

        return $this;
    }

    /**
     * Gets matching command for given arguments
     * @param array<int, string> $argv
     * @return Command
     */
    public function getCommandForArgument(array $argv): Command
    {
        $argv += [null, null, null];

        //Command
        if (isset($this->commands[$argv[1]])) {
            return $this->commands[$argv[1]];
        }

        //Alias
        $alias = isset($this->aliases[$argv[1]])
                ? $this->aliases[$argv[1]]
                : null;

        if (isset($this->commands[$alias])) {
            return $this->commands[$alias];
        }

        //Default command
        return $this->commands[$this->default];
    }

    /**
     * Return the input/output instance
     * @param Interactor|null $io
     * @return Interactor
     */
    public function io(?Interactor $io = null): Interactor
    {
        if ($io || !$this->io) {
            $this->io = $io ? $io : new Interactor();
        }

        return $this->io;
    }

    /**
     * Parse the arguments via the matching command
     * but don't execute command.
     * @param array<int, string> $argv
     * @return Command
     */
    public function parse(array $argv): Command
    {
        $this->argv = $argv;

        $command = $this->getCommandForArgument($argv);
        $aliases = $this->getAliasesForCommand($command);

        foreach ($argv as $i => $arg) {
            if (in_array($arg, $aliases)) {
                unset($argv[$i]);

                break;
            }

            if ($arg[0] === '-') {
                break;
            }
        }

        return $command->parse($argv);
    }

    /**
     * Handle the request, execute command and call exit handler.
     * @param array<int, string> $argv
     * @return mixed
     */
    public function handle(array $argv)
    {
        if (count($argv) < 2) {
            return $this->showHelp();
        }

        $exitCode = 255;

        try {
            $command = $this->parse($argv);
            $result = $this->executeCommand($command);

            $exitCode = is_int($result) ? $result : 0;
        } catch (Throwable $ex) {
            if ($ex instanceof ConsoleException) {
                $this->io()->writer()->red($ex->getMessage(), true);
            } else {
                $this->outputHelper()->printTrace($ex);
            }
        }

        return ($this->onExit)($exitCode);
    }

    /**
     * Show help of all commands.
     * @return mixed
     */
    public function showHelp()
    {
        $writer = $this->io()->writer();

        $header = sprintf(
            '%s, version %s',
            $this->name,
            $this->version
        );

        $footer = 'Run `<command> --help` for specific help';

        if ($this->logo) {
            $writer->write($this->logo, true);
        }

        $this->outputHelper()
                ->showCommandsHelp(
                    $this->getCommands(),
                    $header,
                    $footer
                );

        return ($this->onExit)(0);
    }

    /**
     * Return the list of alias for given command
     * @param Command $command
     * @return array<int, string>
     */
    public function getAliasesForCommand(Command $command): array
    {
        $name = $command->getName();
        $aliases = [$name];

        foreach ($this->aliases as $alias => $commandName) {
            if (in_array($name, [$alias, $commandName])) {
                $aliases[] = $alias;
                $aliases[] = $commandName;
            }
        }

        return $aliases;
    }

    /**
     * Execute the given command and return the result
     * @param Command $command
     * @return mixed
     */
    protected function executeCommand(Command $command)
    {
        if ($command->getName() === '__default__') {
            return $this->showCommandNotFound();
        }

        // Let the command collect more data
        // (if missing or needs confirmation)
        $command->interact($this->io()->reader(), $this->io()->writer());

        return $command->execute();
    }

    /**
     * Return the output helper instance
     * @return OutputHelper
     */
    protected function outputHelper(): OutputHelper
    {
        $writer = $this->io()->writer();

        return new OutputHelper($writer);
    }

    /**
     * Command not found handler.
     * @return mixed
     */
    protected function showCommandNotFound()
    {
        $available = array_keys($this->getCommands() + $this->aliases);

        $this->outputHelper()
                ->showCommandNotFound($this->argv[1], $available);

        return ($this->onExit)(127);
    }
}
