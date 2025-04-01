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
 *  @file Parameter.php
 *
 *  The Input Parameter class
 *
 *  @package    Platine\Console\Input
 *  @author Platine Developers Team
 *  @copyright  Copyright (c) 2020
 *  @license    http://opensource.org/licenses/MIT  MIT License
 *  @link   https://www.platine-php.com
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Console\Input;

use Platine\Console\Util\Helper;

/**
 * @class Parameter
 * @package Platine\Console\Input
 */
abstract class Parameter
{
    /**
     * The name of the parameter
     * @var string
     */
    protected string $name;

    /**
     * The raw data of the parameter
     * @var string
     */
    protected string $raw;

    /**
     * The description of the parameter
     * @var string
     */
    protected string $description;

    /**
     * The parameter default value
     * @var mixed
     */
    protected $default = null;

    /**
     * The sanitizer/filter callback
     * @var callable|null
     */
    protected $filter = null;

    /**
     * Whether the parameter is required
     * @var bool
     */
    protected bool $required = false;

    /**
     * Whether the parameter is variadic
     * @var bool
     */
    protected bool $variadic = false;

    /**
     * Create new instance
     * @param string $raw
     * @param string $description
     * @param mixed $default
     * @param bool $required
     * @param bool $variadic
     * @param callable|null $filter
     */
    public function __construct(
        string $raw,
        string $description = '',
        $default = null,
        bool $required = false,
        bool $variadic = false,
        ?callable $filter = null
    ) {
        $this->raw = $raw;
        $this->description = $description;
        $this->default = $default;
        $this->filter = $filter;
        $this->variadic = $variadic;

        $this->required = $required;

        $this->parse($raw);
    }

    /**
     * Parse raw string representation of parameter.
     * @param string $raw
     * @return void
     */
    abstract public function parse(string $raw): void;

    /**
     * Return the parameter name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Return the parameter raw value
     * @return string
     */
    public function getRaw(): string
    {
        return $this->raw;
    }

    /**
     * Return the parameter description
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Return the parameter default value
     * @return mixed
     */
    public function getDefault()
    {
        if ($this->isVariadic()) {
            return (array) $this->default;
        }

        return $this->default;
    }

    /**
     * Return the parameter filter/sanitizer callback
     * @return callable|null
     */
    public function getFilter(): ?callable
    {
        return $this->filter;
    }

    /**
     * Whether the parameter is required
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * Whether the parameter is variadic
     * @return bool
     */
    public function isVariadic(): bool
    {
        return $this->variadic;
    }

    /**
     * Run the filter/sanitizer/validation callback for
     * the given value
     * @param mixed $raw
     * @return mixed
     */
    public function filter($raw)
    {
        if ($this->filter !== null) {
            $callback = $this->filter;

            return ($callback)($raw);
        }

        return $raw;
    }

    /**
     * Return normalized name of this parameter
     * @return string
     */
    public function getAttributeName(): string
    {
        return Helper::toCamelCase($this->name);
    }
}
