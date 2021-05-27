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
 *  @file Writer.php
 *
 *  The Output Writer class
 *
 *  @package    Platine\Console\Output
 *  @author Platine Developers Team
 *  @copyright  Copyright (c) 2020
 *  @license    http://opensource.org/licenses/MIT  MIT License
 *  @link   http://www.iacademy.cf
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Console\Output;

/**
 * Class Writer
 * @package Platine\Console\Output
 */
class Writer
{

    /**
     * The output stream
     * @var resource
     */
    protected $stream;

    /**
     * The output error stream
     * @var resource
     */
    protected $errorStream;

    /**
     * Color method to be called
     * @var string
     */
    protected string $method;

    /**
     * The color instance
     * @var Color
     */
    protected Color $color;

    /**
     * The cursor instance
     * @var Cursor
     */
    protected Cursor $cursor;

    /**
     * Create new instance
     * @param string|null $path the output write path
     * @param Color|null $color the color instance
     */
    public function __construct(?string $path = null, ?Color $color = null)
    {
        $stream = null;
        if ($path !== null) {
            $stream = fopen($path, 'w');
        }

        $this->stream = $stream ? $stream : STDOUT;
        $this->errorStream = $stream ? $stream : STDERR;

        $this->color = $color ? $color : new Color();
        $this->cursor = new Cursor();
    }

    /**
     * Return the color instance
     * @return Color
     */
    public function getColor(): Color
    {
        return $this->color;
    }

    /**
     * Return the cursor instance
     * @return Cursor
     */
    public function getCursor(): Cursor
    {
        return $this->cursor;
    }

    /**
     * Write the formatted text to standard output.
     * @param string $text
     * @param bool $eol
     * @return $this
     */
    public function write(string $text, bool $eol = false): self
    {
        $styledText = $this->color->line($text);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text to standard error.
     * @param string $text
     * @param bool $eol
     * @return $this
     */
    public function writeError(string $text, bool $eol = false): self
    {
        $styledText = $this->color->red($text);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, true);
    }

    /**
     * Write the formatted text to standard output using custom style.
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $bg
     * @param int|null $mode
     * @return $this
     */
    public function line(
        string $text,
        bool $eol = false,
        ?int $fg = Color::WHITE,
        ?int $bg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->line($text, $fg, $bg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text to standard error
     *  using custom style.
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $bg
     * @param int|null $mode
     * @return $this
     */
    public function lineError(
        string $text,
        bool $eol = false,
        ?int $fg = Color::WHITE,
        ?int $bg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->line($text, $fg, $bg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, true);
    }

    /**
     * Write the formatted text with RED color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $bg
     * @param int|null $mode
     * @return $this
     */
    public function red(
        string $text,
        bool $eol = false,
        ?int $bg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->red($text, $bg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with black color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $bg
     * @param int|null $mode
     * @return $this
     */
    public function black(
        string $text,
        bool $eol = false,
        ?int $bg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->black($text, $bg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with green color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $bg
     * @param int|null $mode
     * @return $this
     */
    public function green(
        string $text,
        bool $eol = false,
        ?int $bg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->green($text, $bg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with yellow color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $bg
     * @param int|null $mode
     * @return $this
     */
    public function yellow(
        string $text,
        bool $eol = false,
        ?int $bg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->yellow($text, $bg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with blue color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $bg
     * @param int|null $mode
     * @return $this
     */
    public function blue(
        string $text,
        bool $eol = false,
        ?int $bg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->blue($text, $bg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with purple color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $bg
     * @param int|null $mode
     * @return $this
     */
    public function purple(
        string $text,
        bool $eol = false,
        ?int $bg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->purple($text, $bg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with cyan color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $bg
     * @param int|null $mode
     * @return $this
     */
    public function cyan(
        string $text,
        bool $eol = false,
        ?int $bg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->cyan($text, $bg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with white color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $bg
     * @param int|null $mode
     * @return $this
     */
    public function white(
        string $text,
        bool $eol = false,
        ?int $bg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->white($text, $bg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with gray color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $bg
     * @param int|null $mode
     * @return $this
     */
    public function gray(
        string $text,
        bool $eol = false,
        ?int $bg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->gray($text, $bg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with dark gray color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $bg
     * @param int|null $mode
     * @return $this
     */
    public function darkgray(
        string $text,
        bool $eol = false,
        ?int $bg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->darkgray($text, $bg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with gray background color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $mode
     * @return $this
     */
    public function bgRed(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->bgRed($text, $fg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with black background color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $mode
     * @return $this
     */
    public function bgBlack(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->bgBlack($text, $fg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with green background color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $mode
     * @return $this
     */
    public function bgGreen(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->bgGreen($text, $fg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with yellow background color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $mode
     * @return $this
     */
    public function bgYellow(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->bgYellow($text, $fg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with blue background color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $mode
     * @return $this
     */
    public function bgBlue(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->bgBlue($text, $fg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with purple background color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $mode
     * @return $this
     */
    public function bgPurple(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->bgPurple($text, $fg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with cyan background color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $mode
     * @return $this
     */
    public function bgCyan(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->bgCyan($text, $fg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with white background color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $mode
     * @return $this
     */
    public function bgWhite(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->bgWhite($text, $fg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with gray background color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $mode
     * @return $this
     */
    public function bgGray(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->bgGray($text, $fg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted text with dark gray background color to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $mode
     * @return $this
     */
    public function bgDarkgray(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $mode = null
    ): self {
        $styledText = $this->color->bgDarkgray($text, $fg, $mode);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted bold text to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $bg
     * @return $this
     */
    public function bold(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $bg = null
    ): self {
        $styledText = $this->color->bold($text, $fg, $bg);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted dim text to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $bg
     * @return $this
     */
    public function dim(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $bg = null
    ): self {
        $styledText = $this->color->dim($text, $fg, $bg);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted italic text to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $bg
     * @return $this
     */
    public function italic(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $bg = null
    ): self {
        $styledText = $this->color->italic($text, $fg, $bg);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted underline text to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $bg
     * @return $this
     */
    public function underline(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $bg = null
    ): self {
        $styledText = $this->color->underline($text, $fg, $bg);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted blink text to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $bg
     * @return $this
     */
    public function blink(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $bg = null
    ): self {
        $styledText = $this->color->blink($text, $fg, $bg);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted reverse text to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $bg
     * @return $this
     */
    public function reverse(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $bg = null
    ): self {
        $styledText = $this->color->reverse($text, $fg, $bg);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the formatted hidden text to standard output
     * @param string $text
     * @param bool $eol
     * @param int|null $fg
     * @param int|null $bg
     * @return $this
     */
    public function hidden(
        string $text,
        bool $eol = false,
        ?int $fg = null,
        ?int $bg = null
    ): self {
        $styledText = $this->color->hidden($text, $fg, $bg);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write formatted text in HTML style
     * @see Color::colors
     *
     * @param string $text
     * @param bool $eol
     * @return $this
     */
    public function colors(string $text, bool $eol = false): self
    {
        $styledText = $this->color->colors($text);
        if ($eol) {
            $styledText .= PHP_EOL;
        }

        return $this->doWrite($styledText, false);
    }

    /**
     * Write the raw text to stream.
     * @param string $text
     * @param bool $error
     * @return $this
     */
    public function raw(string $text, bool $error = false): self
    {
        return $this->doWrite($text, $error);
    }

    /**
     * Generate table for the console
     * @param array<int, array<int, string>> $rows
     * @param array<string, string> $styles
     * @return self
     */
    public function table(array $rows, array $styles = []): self
    {
        $table = (new Table())->render($rows, $styles);
        $output = $this->color->colors($table);

        $this->write($output, true);

        return $this;
    }

    /**
     * Write EOL count times.
     * @param int $count
     * @return $this
     */
    public function eol(int $count = 1): self
    {
        return $this->doWrite(str_repeat(PHP_EOL, max($count, 1)), false);
    }

    /**
     * Write to the standard output or standard error stream.
     * @param string $text
     * @param bool $error
     * @return $this
     */
    protected function doWrite(string $text, bool $error = false): self
    {
        $stream = $error ? $this->errorStream : $this->stream;

        fwrite($stream, $text);

        return $this;
    }
}
