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
 *  @file Helper.php
 *
 *  The console helper class
 *
 *  @package    Platine\Console\Util
 *  @author Platine Developers Team
 *  @copyright  Copyright (c) 2020
 *  @license    http://opensource.org/licenses/MIT  MIT License
 *  @link   http://www.iacademy.cf
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Console\Util;

use Platine\Console\Input\Option;
use Platine\Console\Input\Parameter;

/**
 * Class Helper
 * @package Platine\Console\Util
 */
class Helper
{

    /**
     * Convert the given string to camel case
     * @param string $str
     * @return string
     */
    public static function toCamelCase(string $str): string
    {
        $words = str_replace(['-', '_'], ' ', $str);
        $wordsToUpper = str_replace(' ', '', ucwords($words));

        return lcfirst($wordsToUpper);
    }

    /**
     * Convert the given string to capitalized words
     * @param string $str
     * @return string
     */
    public static function toWords(string $str): string
    {
        $words = trim(str_replace(['-', '_'], ' ', $str));

        return ucwords($words);
    }

    /**
     * Normalize arguments like splitting "-abc" and "--xyz=...".
     * @param array<int, string> $args
     * @return array<string>
     */
    public static function normalizeArguments(array $args): array
    {
        $normalized = [];

        foreach ($args as $arg) {
            if (preg_match('/^\-\w=/', $arg)) {
                $parts = explode('=', $arg);
                if ($parts !== false) {
                    $normalized = array_merge($normalized, $parts);
                }
            } elseif (preg_match('/^\-\w{2,}/', $arg)) {
                $splitArgs = implode(' -', str_split(ltrim($arg, '-')));
                $parts = explode(' ', '-' . $splitArgs);
                if ($parts !== false) {
                    $normalized = array_merge($normalized, $parts);
                }
            } elseif (preg_match('/^\-\-([^\s\=]+)\=/', $arg)) {
                $parts = explode('=', $arg);
                if ($parts !== false) {
                    $normalized = array_merge($normalized, $parts);
                }
            } else {
                $normalized[] = $arg;
            }
        }

        return $normalized;
    }

    /**
     * Normalizes value as per context and runs though filter if possible.
     * @param Parameter $parameter
     * @param string|null $value
     * @return mixed
     */
    public static function normalizeValue(Parameter $parameter, ?string $value = null)
    {
        if ($parameter instanceof Option && $parameter->isBool()) {
            return !$parameter->getDefault();
        }

        if ($parameter->isVariadic()) {
            return (array) $value;
        }

        if ($value === null) {
            return $parameter->isRequired() ? null : true;
        }

        return $parameter->filter($value);
    }

    /**
     * Check if the array is associative.
     * @param array<int|string, mixed> $values
     * @return bool
     */
    public static function isAssocArray(array $values): bool
    {
        return !empty($values)
                    && array_keys($values) !== range(0, count($values) - 1);
    }
}
