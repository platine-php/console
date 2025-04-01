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
 *  @file Table.php
 *
 *  The Output Table class
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

use Platine\Console\Exception\InvalidArgumentException;
use Platine\Console\Util\Helper;

/**
 * @class Table
 * @package Platine\Console\Output
 */
class Table
{
    /**
     * Render table data
     * @param array<int, array<int, array<string, string>>> $rows
     * @param array<string, string> $styles
     * @return string
     */
    public function render(array $rows, array $styles = []): string
    {
        $normalizedTable = $this->normalize($rows);
        if (count($normalizedTable) === 0) {
            return '';
        }

        /** @var array<string, int> $head */
        $head = $normalizedTable['header'];

        /** @var array<int, array<string, string>> $tableRows */
        $tableRows = $normalizedTable['rows'];

        $normalizedStyles = $this->normalizeStyles($styles);
        $title = [];
        $dash = [];
        $body = [];

        list($start, $end) = $normalizedStyles['head'];
        /** @var string $col */
        /** @var int $size */
        foreach ($head as $col => $size) {
            $dash[] = str_repeat('-', $size + 2);
            $title[] = str_pad(Helper::toWords($col), $size, ' ');
        }

        $titleStr = '|' . $start . ' '
                . implode(' ' . $end . '|' . $start . ' ', $title)
                . ' ' . $end . '|' . PHP_EOL;

        $odd = true;
        foreach ($tableRows as /** @var array<int, array<string, string>> $row */ $row) {
            $parts = [];
            list($start, $end) = $normalizedStyles[['even', 'odd'][(int) $odd]];
            /** @var string $col */
            /** @var int $size */
            foreach ($head as $col => $size) {
                $parts[] = str_pad(isset($row[$col]) ? $row[$col] : '', $size, ' ');
            }

            $odd = !$odd;
            $body[] = '|' . $start . ' '
                    . implode(' ' . $end . '|' . $start . ' ', $parts)
                    . ' ' . $end . '|';
        }

        $dashStr = '+' . implode('+', $dash) . '+' . PHP_EOL;
        $bodyStr = implode(PHP_EOL, $body) . PHP_EOL;

        return $dashStr . $titleStr . $dashStr . $bodyStr . $dashStr;
    }

    /**
     * Normalize table data
     * @param array<int, array<mixed>|mixed> $rows
     * @return array<string, array<mixed>>
     */
    protected function normalize(array $rows): array
    {
        $head = reset($rows);

        if ($head === false) {
            return [];
        }

        if (!is_array($head)) {
            throw new InvalidArgumentException(sprintf(
                'Table rows must be an array of assoc arrays, [%s] given',
                gettype($head)
            ));
        }

        if (count($head) === 0) {
            return [];
        }

        $header = array_fill_keys(array_keys($head), null);
        foreach ($rows as &$row) {
            $row = array_merge($header, $row);
        }

        /** @var array<string, string> $header */
        foreach ($header as $col => &$value) {
            /** @var array<string> $cols */
            $cols = array_column($rows, $col);
            $span = array_map(fn($a) => strlen($a), $cols);
            $span[] = strlen($col);
            $value = max($span);
        }

        return [
            'header' => $header,
            'rows' => $rows
        ];
    }

    /**
     * Normalize table styles
     * @param array<string, string> $styles
     * @return array<string, array<string>>
     */
    protected function normalizeStyles(array $styles): array
    {
        $default = [
            'head' => ['', ''],
            'odd' => ['', ''],
            'even' => ['', ''],
        ];

        foreach ($styles as $for => $style) {
            if (isset($default[$for])) {
                $default[$for] = ['<' . trim($style, '<> ') . '>', '</end>'];
            }
        }

        return $default;
    }
}
