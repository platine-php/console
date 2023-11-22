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
 *  @file Cursor.php
 *
 *  The Output Cursor class
 *
 *  @package    Platine\Console\Output
 *  @author Platine Developers Team
 *  @copyright  Copyright (c) 2020
 *  @license    http://opensource.org/licenses/MIT  MIT License
 *  @link   https://www.platine-php.com
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Console\Output;

/**
 * Class Cursor
 * @package Platine\Console\Output
 */
class Cursor
{
    /**
     * Returns signal to move cursor up "count" times.
     * @param int $count
     * @return string
     */
    public function up(int $count = 1): string
    {
        return sprintf("\e[%dA", max($count, 1));
    }

    /**
     * Returns signal to move cursor down "count" times.
     * @param int $count
     * @return string
     */
    public function down(int $count = 1): string
    {
        return sprintf("\e[%dB", max($count, 1));
    }

    /**
     * Returns signal to move cursor right "count" times.
     * @param int $count
     * @return string
     */
    public function right(int $count = 1): string
    {
        return sprintf("\e[%dC", max($count, 1));
    }

    /**
     * Returns signal to move cursor left "count" times.
     * @param int $count
     * @return string
     */
    public function left(int $count = 1): string
    {
        return sprintf("\e[%dD", max($count, 1));
    }

    /**
     * Returns signal to move cursor next line "count" times.
     * @param int $count
     * @return string
     */
    public function next(int $count = 1): string
    {
        return str_repeat("\e[E", max($count, 1));
    }

    /**
     * Returns signal to move cursor previous line "count" times.
     * @param int $count
     * @return string
     */
    public function prev(int $count = 1): string
    {
        return str_repeat("\e[F", max($count, 1));
    }

    /**
     * Returns signal to erase current line.
     * @return string
     */
    public function eraseLine(): string
    {
        return "\e[2K";
    }

    /**
     * Returns signal to clear string.
     * @return string
     */
    public function clear(): string
    {
        return "\e[2K";
    }

    /**
     * Returns signal to erase lines upward.
     * @return string
     */
    public function clearUp(): string
    {
        return "\e[1J";
    }

    /**
     * Returns signal to erase lines downward.
     * @return string
     */
    public function clearDown(): string
    {
        return "\e[J";
    }

    /**
     * Returns signal to move cursor to given x, y position.
     * @param int $x
     * @param int $y
     * @return string
     */
    public function moveTo(int $x, int $y): string
    {
        return sprintf("\e[%d;%dH", $y, $x);
    }
}
