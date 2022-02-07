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
 *  @file Interactor.php
 *
 *  The Input/Output interaction class
 *
 *  @package    Platine\Console\IO
 *  @author Platine Developers Team
 *  @copyright  Copyright (c) 2020
 *  @license    http://opensource.org/licenses/MIT  MIT License
 *  @link   http://www.iacademy.cf
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Console\IO;

use Platine\Console\Input\Reader;
use Platine\Console\Output\Color;
use Platine\Console\Output\Writer;
use Platine\Console\Util\Helper;
use Throwable;

/**
 * Class Interactor
 * @package Platine\Console\IO
 */
class Interactor
{

    /**
     * Stream reader instance
     * @var Reader
     */
    protected Reader $reader;

    /**
     * Stream writer instance
     * @var Writer
     */
    protected Writer $writer;

    /**
     * Create new instance
     * @param string|null $input
     * @param string|null $output
     */
    public function __construct(?string $input = null, ?string $output = null)
    {
        $this->reader = new Reader($input);
        $this->writer = new Writer($output);
    }

    /**
     * Return the reader instance
     * @return Reader
     */
    public function reader(): Reader
    {
        return $this->reader;
    }

    /**
     * Return the writer instance
     * @return Writer
     */
    public function writer(): Writer
    {
        return $this->writer;
    }

    /**
     * Confirms if user agrees to prompt as indicated by given text.
     * @param string $text
     * @param string $default
     * @return bool
     */
    public function confirm(string $text, string $default = 'y'): bool
    {
        $choice = $this->choice($text, ['y', 'n'], $default, false);

        return strtolower(isset($choice[0]) ? $choice[0] : $default) === 'y';
    }

    /**
     * Let user make a choice out of available choices.
     * @param string $text
     * @param array<int|string, string> $choices
     * @param mixed $default
     * @param bool $case
     *
     * @return mixed
     */
    public function choice(string $text, array $choices, $default = null, bool $case = false)
    {
        $this->writer->yellow($text);

        $this->listOptions($choices, $default, false);

        $choice = $this->reader->read($default);

        return $this->isValidChoice($choice, $choices, $case)
                ? $choice
                : $default;
    }

    /**
     * Let user make multiple choice out of available choices.
     * @param string $text
     * @param array<int|string, string> $choices
     * @param mixed $default
     * @param bool $case
     *
     * @return mixed
     */
    public function choices(string $text, array $choices, $default = null, bool $case = false)
    {
        $this->writer->yellow($text);

        $this->listOptions($choices, $default, true);

        $choice = $this->reader->read($default);
        $values = [];
        if (is_string($choice)) {
            $values = explode(',', str_replace(' ', '', $choice));
        }

        $valid = [];

        foreach ($values as $option) {
            if ($this->isValidChoice($option, $choices, $case)) {
                $valid[] = $option;
            }
        }

        return !empty($valid) ? $valid : (array) $default;
    }

    /**
     * Prompt user for free input.
     * @param string $text
     * @param mixed $default
     * @param callable|null $callback
     * @param bool $required
     * @param bool $hidden
     * @return mixed
     */
    public function prompt(
        string $text,
        $default = null,
        ?callable $callback = null,
        bool $required = true,
        bool $hidden = false
    ) {
        $error = 'Invalid value, please try again';
        $readFunct = ['read', 'readHidden'][(int) $hidden];

        $this->writer->yellow($text);

        $this->writer->dim(
            $default !== null
                            ? ' [' . $default . ']: '
                            : ': '
        );

        try {
            $input = $this->reader->{$readFunct}($default, $callback);
        } catch (Throwable $ex) {
            $input = '';
            $error = $ex->getMessage();
        }

        while ($required && $input === '') {
            $this->writer->bgRed($error, true);

            $input = $this->prompt($text, $default, $callback, $required, $hidden);
        }

        return $input ? $input : $default;
    }

    /**
     * Prompt user for secret input like password.
     * Currently for Unix only.
     * @param string $text
     * @param callable|null $callback
     * @param bool $required
     * @return mixed
     */
    public function promptHidden(
        string $text,
        ?callable $callback = null,
        bool $required = true
    ) {
        return $this->prompt($text, null, $callback, $required, true);
    }

    /**
     * Show choices list.
     * @param array<int|string, string> $choices
     * @param mixed $default
     * @param bool $isMutliple
     * @return $this
     */
    protected function listOptions(
        array $choices,
        $default = null,
        bool $isMutliple = false
    ): self {
        if (!Helper::isAssocArray($choices)) {
            return $this->promptOptions($choices, $default);
        }

        $maxLength = max(array_map('strlen', array_keys($choices)));

        foreach ($choices as $choice => $desc) {
            $this->writer->eol()
                         ->cyan(
                             str_pad(' [' . $choice . ']', $maxLength + 6)
                         );

            $this->writer->dim($desc);
        }

        $label = $isMutliple ? 'Choices (comma separated)' : 'Choice';

        $this->writer->eol()->yellow($label);

        /** @var array<string> $keys */
        $keys = array_keys($choices);

        return $this->promptOptions($keys, $default);
    }

    /**
     * Show prompt with possible options.
     * @param array<int|string, string> $choices
     * @param mixed $default
     * @return $this
     */
    protected function promptOptions(array $choices, $default): self
    {
        $options = '';

        foreach ($choices as $choice) {
            $style = in_array($choice, (array) $default) ? 'info' : 'ok';
            $options .= '/<' . $style . '>' . $choice . '</end>';
        }

        $finalOptions = ltrim($options, '/');

        $this->writer()->colors(' (' . $finalOptions . '): ');

        return $this;
    }

    /**
     * Check if user choice is one of possible choices.
     * @param string $choice
     * @param array<int|string, string> $choices
     * @param bool $case
     * @return bool
     */
    protected function isValidChoice(string $choice, array $choices, bool $case): bool
    {
        if (Helper::isAssocArray($choices)) {
            /** @var array<string> $choices */
            $choices = array_keys($choices);
        }

        $func = ['strcasecmp', 'strcmp'][(int) $case];
        foreach ($choices as $option) {
            //Don't use === here
            if ($func($choice, (string) $option) == 0) {
                return true;
            }
        }

        return false;
    }
}
