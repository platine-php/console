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
 *  @file Option.php
 *
 *  The Input Option class
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

/**
 * @class Option
 * @package Platine\Console\Input
 */
class Option extends Parameter
{
    /**
     * The short option name
     * @var string
     */
    protected string $short = '';

     /**
     * The long option name
     * @var string
     */
    protected string $long = '';

    /**
     * {@inheritdoc}
     */
    public function parse(string $raw): void
    {
        if (strpos($this->raw, '-with-') !== false) {
            $this->default = false;
        } elseif (strpos($this->raw, '-no-') !== false) {
            $this->default = true;
        }

        $parts = preg_split('/[\s,\|]+/', $raw);

        if ($parts !== false) {
            $this->short = $parts[0];
            $this->long = $parts[0];

            if (isset($parts[1])) {
                $this->long = $parts[1];
            }
        }

        $this->name = str_replace(['--', 'no-', 'with-'], '', $this->long);
    }

    /**
     * Return the short option name
     * @return string
     */
    public function getShort(): string
    {
        return $this->short;
    }

    /**
     * Return the long option name
     * @return string
     */
    public function getLong(): string
    {
        return $this->long;
    }

    /**
     * Whether the given argument match option name
     * @param string $arg
     * @return bool
     */
    public function is(string $arg): bool
    {
        return $this->short === $arg
              || $this->long === $arg;
    }

    /**
     * Check if the option is bool type.
     * @return bool
     */
    public function isBool(): bool
    {
        return preg_match('/\-no-|\-with-/', $this->long) > 0;
    }
}
