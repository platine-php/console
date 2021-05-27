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
 *  @file Color.php
 *
 *  The Output Color class
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
 * Class Color
 * @package Platine\Console\Output
 */
class Color
{

    /**
     * The color constants
     */
    public const BLACK    = 30;
    public const RED      = 31;
    public const GREEN    = 32;
    public const YELLOW   = 33;
    public const BLUE     = 34;
    public const PURPLE   = 35;
    public const CYAN     = 36;
    public const WHITE    = 37;
    public const GRAY     = 47;
    public const DARKGRAY = 100;

    /**
     * The background color constants
     */
    public const BG_BLACK    = 40;
    public const BG_RED      = 41;
    public const BG_GREEN    = 42;
    public const BG_YELLOW   = 43;
    public const BG_BLUE     = 44;
    public const BG_PURPLE   = 45;
    public const BG_CYAN     = 46;
    public const BG_WHITE    = 47;
    public const BG_GRAY     = 57;
    public const BG_DARKGRAY = 110;

    /**
     * The style constants
     */
    public const BOLD = 1;
    public const DIM = 2;
    public const ITALIC = 3;
    public const UNDERLINE = 4;
    public const BLINK = 5;
    public const REVERSE = 7;
    public const HIDDEN = 8;

    /**
     * The console color style format
     * @var string
     */
    protected string $format = "\033[:mod:;:fg:;:bg:m:txt:\033[0m";

    /**
     * Returns a line formatted as comment.
     * @param string $text
     * @return string
     */
    public function comment(string $text): string
    {
        return $this->line($text, null, null, self::DIM);
    }

    /**
     * Returns a line formatted as error.
     * @param string $text
     * @return string
     */
    public function error(string $text): string
    {
        return $this->red($text);
    }

    /**
     * Returns a line formatted ok error.
     * @param string $text
     * @return string
     */
    public function ok(string $text): string
    {
        return $this->green($text);
    }

    /**
     * Returns a line formatted as warning.
     * @param string $text
     * @return string
     */
    public function warn(string $text): string
    {
        return $this->yellow($text);
    }

    /**
     * Returns a line formatted as information.
     * @param string $text
     * @return string
     */
    public function info(string $text): string
    {
        return $this->blue($text);
    }

    /**
     * Returns a formatted/colored line.
     * @param string $text
     * @param int|null $fg
     * @param int|null $bg
     * @param int|null $mode
     * @return string
     */
    public function line(
        string $text,
        ?int $fg = self::WHITE,
        ?int $bg = null,
        ?int $mode = null
    ): string {
        $style = [
            'bg' => $bg,
            'fg' => $fg === null ? self::WHITE : $fg,
            'mod' => $mode,
        ];

        $format = $style['bg'] === null
                ? str_replace(';:bg:', '', $this->format)
                : $this->format;

        $line = strtr($format, [
            ':mod:' => (int) $style['mod'],
            ':fg:' => $style['fg'],
            ':bg:' => $style['bg'],
            ':txt:' => $text
        ]);

        return $line;
    }

    /**
     * Return formatted text with RED color
     * @param string $text
     * @param int|null $bg
     * @param int|null $mode
     * @return string
     */
    public function red(string $text, ?int $bg = null, ?int $mode = null): string
    {
        return $this->line($text, self::RED, $bg, $mode);
    }

    /**
     * Return formatted text with BLCAK color
     * @param string $text
     * @param int|null $bg
     * @param int|null $mode
     * @return string
     */
    public function black(string $text, ?int $bg = null, ?int $mode = null): string
    {
        return $this->line($text, self::BLACK, $bg, $mode);
    }

    /**
     * Return formatted text with GREEN color
     * @param string $text
     * @param int|null $bg
     * @param int|null $mode
     * @return string
     */
    public function green(string $text, ?int $bg = null, ?int $mode = null): string
    {
        return $this->line($text, self::GREEN, $bg, $mode);
    }

    /**
     * Return formatted text with YELLOW color
     * @param string $text
     * @param int|null $bg
     * @param int|null $mode
     * @return string
     */
    public function yellow(string $text, ?int $bg = null, ?int $mode = null): string
    {
        return $this->line($text, self::YELLOW, $bg, $mode);
    }

    /**
     * Return formatted text with BLUE color
     * @param string $text
     * @param int|null $bg
     * @param int|null $mode
     * @return string
     */
    public function blue(string $text, ?int $bg = null, ?int $mode = null): string
    {
        return $this->line($text, self::BLUE, $bg, $mode);
    }

    /**
     * Return formatted text with PURPLE color
     * @param string $text
     * @param int|null $bg
     * @param int|null $mode
     * @return string
     */
    public function purple(string $text, ?int $bg = null, ?int $mode = null): string
    {
        return $this->line($text, self::PURPLE, $bg, $mode);
    }

    /**
     * Return formatted text with CYAN color
     * @param string $text
     * @param int|null $bg
     * @param int|null $mode
     * @return string
     */
    public function cyan(string $text, ?int $bg = null, ?int $mode = null): string
    {
        return $this->line($text, self::CYAN, $bg, $mode);
    }

    /**
     * Return formatted text with WHITE color
     * @param string $text
     * @param int|null $bg
     * @param int|null $mode
     * @return string
     */
    public function white(string $text, ?int $bg = null, ?int $mode = null): string
    {
        return $this->line($text, self::WHITE, $bg, $mode);
    }

    /**
     * Return formatted text with GRAY color
     * @param string $text
     * @param int|null $bg
     * @param int|null $mode
     * @return string
     */
    public function gray(string $text, ?int $bg = null, ?int $mode = null): string
    {
        return $this->line($text, self::GRAY, $bg, $mode);
    }

    /**
     * Return formatted text with DARK GRAY color
     * @param string $text
     * @param int|null $bg
     * @param int|null $mode
     * @return string
     */
    public function darkgray(string $text, ?int $bg = null, ?int $mode = null): string
    {
        return $this->line($text, self::DARKGRAY, $bg, $mode);
    }

    /**
     * Return formatted text with RED background color
     * @param string $text
     * @param int|null $fg
     * @param int|null $mode
     * @return string
     */
    public function bgRed(string $text, ?int $fg = null, ?int $mode = null): string
    {
        return $this->line($text, $fg, self::BG_RED, $mode);
    }

    /**
     * Return formatted text with BLCAK background color
     * @param string $text
     * @param int|null $fg
     * @param int|null $mode
     * @return string
     */
    public function bgBlack(string $text, ?int $fg = null, ?int $mode = null): string
    {
        return $this->line($text, $fg, self::BG_BLACK, $mode);
    }

    /**
     * Return formatted text with GREEN background color
     * @param string $text
     * @param int|null $fg
     * @param int|null $mode
     * @return string
     */
    public function bgGreen(string $text, ?int $fg = null, ?int $mode = null): string
    {
        return $this->line($text, $fg, self::BG_GREEN, $mode);
    }

    /**
     * Return formatted text with YELLOW background color
     * @param string $text
     * @param int|null $fg
     * @param int|null $mode
     * @return string
     */
    public function bgYellow(string $text, ?int $fg = null, ?int $mode = null): string
    {
        return $this->line($text, $fg, self::BG_YELLOW, $mode);
    }

    /**
     * Return formatted text with BLUE background color
     * @param string $text
     * @param int|null $fg
     * @param int|null $mode
     * @return string
     */
    public function bgBlue(string $text, ?int $fg = null, ?int $mode = null): string
    {
        return $this->line($text, $fg, self::BG_BLUE, $mode);
    }

    /**
     * Return formatted text with PURPLE background color
     * @param string $text
     * @param int|null $fg
     * @param int|null $mode
     * @return string
     */
    public function bgPurple(string $text, ?int $fg = null, ?int $mode = null): string
    {
        return $this->line($text, $fg, self::BG_PURPLE, $mode);
    }

    /**
     * Return formatted text with CYAN background color
     * @param string $text
     * @param int|null $fg
     * @param int|null $mode
     * @return string
     */
    public function bgCyan(string $text, ?int $fg = null, ?int $mode = null): string
    {
        return $this->line($text, $fg, self::BG_CYAN, $mode);
    }

    /**
     * Return formatted text with WHITE background color
     * @param string $text
     * @param int|null $fg
     * @param int|null $mode
     * @return string
     */
    public function bgWhite(string $text, ?int $fg = null, ?int $mode = null): string
    {
        return $this->line($text, $fg, self::BG_WHITE, $mode);
    }

    /**
     * Return formatted text with GRAY background color
     * @param string $text
     * @param int|null $fg
     * @param int|null $mode
     * @return string
     */
    public function bgGray(string $text, ?int $fg = null, ?int $mode = null): string
    {
        return $this->line($text, $fg, self::BG_GRAY, $mode);
    }

    /**
     * Return formatted text with DARK GRAY background color
     * @param string $text
     * @param int|null $fg
     * @param int|null $mode
     * @return string
     */
    public function bgDarkgray(string $text, ?int $fg = null, ?int $mode = null): string
    {
        return $this->line($text, $fg, self::BG_DARKGRAY, $mode);
    }

    /**
     * Return formatted bold text
     * @param string $text
     * @param int|null $fg
     * @param int|null $bg
     * @return string
     */
    public function bold(string $text, ?int $fg = null, ?int $bg = null): string
    {
        return $this->line($text, $fg, $bg, self::BOLD);
    }

    /**
     * Return formatted dim text
     * @param string $text
     * @param int|null $fg
     * @param int|null $bg
     * @return string
     */
    public function dim(string $text, ?int $fg = null, ?int $bg = null): string
    {
        return $this->line($text, $fg, $bg, self::DIM);
    }

    /**
     * Return formatted italic text
     * @param string $text
     * @param int|null $fg
     * @param int|null $bg
     * @return string
     */
    public function italic(string $text, ?int $fg = null, ?int $bg = null): string
    {
        return $this->line($text, $fg, $bg, self::ITALIC);
    }

    /**
     * Return formatted underline text
     * @param string $text
     * @param int|null $fg
     * @param int|null $bg
     * @return string
     */
    public function underline(string $text, ?int $fg = null, ?int $bg = null): string
    {
        return $this->line($text, $fg, $bg, self::UNDERLINE);
    }

    /**
     * Return formatted blink text
     * @param string $text
     * @param int|null $fg
     * @param int|null $bg
     * @return string
     */
    public function blink(string $text, ?int $fg = null, ?int $bg = null): string
    {
        return $this->line($text, $fg, $bg, self::BLINK);
    }

    /**
     * Return formatted reverse text
     * @param string $text
     * @param int|null $fg
     * @param int|null $bg
     * @return string
     */
    public function reverse(string $text, ?int $fg = null, ?int $bg = null): string
    {
        return $this->line($text, $fg, $bg, self::REVERSE);
    }

    /**
     * Return formatted hidden text
     * @param string $text
     * @param int|null $fg
     * @param int|null $bg
     * @return string
     */
    public function hidden(string $text, ?int $fg = null, ?int $bg = null): string
    {
        return $this->line($text, $fg, $bg, self::HIDDEN);
    }

    /**
     * Prepare a multi colored string with HTML like tags.
     * Example: "<errorBold>Text</end><eol/><bgGreenBold>Text</end><eol>"
     * @param string $text
     * @return string
     */
    public function colors(string $text): string
    {
        $rawText = str_replace(
            [
                    '</eol>',
                    "\r\n",
                    "\n"
                ],
            '__PHP_EOL__',
            $text
        );

        $matches = [];

        if (!preg_match_all('/<(\w+)>(.*?)<\/end>/', $rawText, $matches)) {
            return str_replace('__PHP_EOL__', PHP_EOL, $rawText);
        }

        $end = "\033[0m";
        $styledText = str_replace(['</end>'], $end, $rawText);

        foreach ($matches[1] as $method) {
            $part = str_replace($end, '', $this->{$method}(''));
            $styledText = str_replace('<' . $method . '>', $part, $styledText);
        }

        return str_replace('__PHP_EOL__', PHP_EOL, $styledText);
    }
}
