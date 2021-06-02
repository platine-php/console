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
 *  @file Parser.php
 *
 *  The Input Parser class
 *
 *  @package    Platine\Console\Input
 *  @author Platine Developers Team
 *  @copyright  Copyright (c) 2020
 *  @license    http://opensource.org/licenses/MIT  MIT License
 *  @link   http://www.iacademy.cf
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Console\Input;

use Platine\Console\Exception\InvalidParameterException;
use Platine\Console\Exception\RuntimeException;
use Platine\Console\Util\Helper;

/**
 * Class Parser
 * @package Platine\Console\Input
 */
abstract class Parser
{

    /**
     * The last seen variadic option name
     * @var string|null
     */
    protected ?string $lastVariadic = null;

    /**
     * The list of options
     * @var array<Option>
     */
    protected array $options = [];

    /**
     * The list of arguments
     * @var array<Argument>
     */
    protected array $arguments = [];

    /**
     * Parsed values indexed by option name
     * @var array<string|int, mixed>
     */
    protected array $values = [];

    /**
     * The version
     * @var string
     */
    protected string $version = '';


    /**
     * Parse the command line argument.
     * @param array<int, string> $argv
     * @return $this
     */
    public function parse(array $argv): self
    {
        //The first item is ignored.
        array_shift($argv);

        $arguments = Helper::normalizeArguments($argv);

        $count = count($arguments);
        $literal = false;

        for ($i = 0; $i < $count; $i++) {
            list($arg, $nextArg) = [
                $arguments[$i],
                isset($arguments[$i + 1]) ? $arguments[$i + 1] : null
            ];

            if ($arg === '--') {
                $literal = true;
            } elseif ($arg[0] !== '-' || $literal) {
                $this->parseArgument($arg);
            } else {
                $i += (int) $this->parseOptions($arg, $nextArg);
            }
        }

        $this->validate();

        return $this;
    }

    /**
     * Return all options.
     * @return array<Option>
     */
    public function options(): array
    {
        return $this->options;
    }

    /**
     * Return all arguments.
     * @return array<Argument>
     */
    public function arguments(): array
    {
        return $this->arguments;
    }

    /**
     * Get the command arguments i.e which is not an option.
     * @return array<string>
     */
    public function args(): array
    {
        return array_diff_key($this->values, $this->options);
    }

    /**
     * Get values indexed by camel case attribute name.
     * @param bool $withDefaults
     * @return array<string|int, mixed>
     */
    public function values(bool $withDefaults = true): array
    {
        $values = $this->values;
        $values['version'] = $this->version;

        if (!$withDefaults) {
            unset($values['help'], $values['version'], $values['verbosity']);
        }

        return $values;
    }

    /**
     * Handle Unknown option
     * @param string $arg is option name
     * @param string|null $value is option value
     * @return mixed If true it will indicate that value has been eaten.
     */
    abstract protected function handleUnknown(string $arg, $value = null);

    /**
     * Emit the event with value.
     * @param string $event is option name
     * @param mixed $value is option value
     * @return mixed
     */
    abstract protected function emit(string $event, $value = null);

    /**
     * Parse single argument.
     * @param string $arg
     * @return mixed
     */
    protected function parseArgument(string $arg)
    {
        if ($this->lastVariadic) {
            return $this->set($this->lastVariadic, $arg, true);
        }

        /** @var Argument|false $argument */
        $argument = reset($this->arguments);
        if ($argument === false) {
            return $this->set(null, $arg, false);
        }

        $this->setValue($argument, $arg);

        // Otherwise we will always collect same arguments again!
        if (!$argument->isVariadic()) {
            array_shift($this->arguments);
        }
    }

    /**
     * Parse an option, emit its event and set value
     * @param string $arg
     * @param string|null $nextArg
     * @return mixed|bool
     */
    protected function parseOptions(string $arg, ?string $nextArg = null)
    {
        $value = null;
        if ($nextArg !== null && substr($nextArg, 0, 1) !== '-') {
            $value =  $nextArg;
        }

        $option = $this->getOptionForArgument($arg);
        if ($option === null) {
            return $this->handleUnknown($arg, $value);
        }

        $this->lastVariadic = $option->isVariadic()
                ? $option->getAttributeName()
                : null;

        return $this->emit($option->getAttributeName(), $value) === false
                ? false
                : $this->setValue($option, $value);
    }

    /**
     * Get matching option by argument (name) or null.
     * @param string $arg
     * @return Option|null
     */
    protected function getOptionForArgument(string $arg): ?Option
    {
        foreach ($this->options as $option) {
            if ($option->is($arg)) {
                return $option;
            }
        }

        return null;
    }

    /**
     * Set a raw value.
     * @param mixed $key
     * @param mixed $value
     * @param bool $isVariadic
     * @return bool
     */
    protected function set($key, $value, bool $isVariadic = false): bool
    {
        if ($key === null) {
            $this->values[] = $value;
        } elseif ($isVariadic) {
            $this->values[$key] = array_merge(
                isset($this->values[$key]) ? $this->values[$key] : [],
                (array) $value
            );
        } else {
            $this->values[$key] = $value;
        }

        return !in_array($value, [true, false, null], true);
    }

    /**
     * Sets value of an option.
     * @param Parameter $parameter
     * @param string|null $value
     * @return bool
     */
    protected function setValue(Parameter $parameter, ?string $value = null): bool
    {
        $name = $parameter->getAttributeName();
        $normalizedValue = Helper::normalizeValue($parameter, $value);

        return $this->set($name, $normalizedValue, $parameter->isVariadic());
    }

    /**
     * Validate if all required arguments/options have proper values.
     * @return void
     */
    protected function validate(): void
    {
        /** @var array<Parameter> $missingItems */
        $missingItems = array_filter(
            $this->options + $this->arguments,
            function ($item) {
            /** @var Parameter $item */
                return $item->isRequired() && in_array(
                    $this->values[$item->getAttributeName()],
                    [null, []]
                );
            }
        );

        foreach ($missingItems as $item) {
            list($name, $label) = [$item->getName(), 'Argument'];
            if ($item instanceof Option) {
                list($name, $label) = [$item->getLong(), 'Option'];
            }

            throw new RuntimeException(sprintf(
                '%s "%s" is required',
                $label,
                $name
            ));
        }
    }

    /**
     * Register a new argument/option.
     * @param Parameter $parameter
     * @return void
     */
    protected function register(Parameter $parameter): void
    {
        $this->checkDuplicate($parameter);

        $name = $parameter->getAttributeName();

        if ($parameter instanceof Option) {
            $this->options[$name] = $parameter;
        } elseif ($parameter instanceof Argument) {
            $this->arguments[$name] = $parameter;
        }

        $this->set($name, $parameter->getDefault());
    }

    /**
     * Remove a registered argument/option.
     * @param string $name
     * @return void
     */
    protected function unregister(string $name): void
    {
        unset(
            $this->values[$name],
            $this->options[$name],
            $this->arguments[$name]
        );
    }

    /**
     * Check if either argument/option with given name is registered.
     * @param string $name
     * @return bool
     */
    protected function isRegistered(string $name): bool
    {
        return array_key_exists($name, $this->values);
    }

    /**
     * What if the given name is already registered.
     * @param Parameter $parameter
     * @return void
     */
    protected function checkDuplicate(Parameter $parameter): void
    {
        if ($this->isRegistered($parameter->getAttributeName())) {
            throw new InvalidParameterException(sprintf(
                'The parameter [%s] is already registered',
                $parameter instanceof Option
                    ? $parameter->getLong()
                    : $parameter->getName()
            ));
        }
    }
}
