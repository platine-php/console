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
 *  @link   http://www.iacademy.cf
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Console\Output;

use Platine\Console\Exception\InvalidArgumentException;
use Platine\Console\Util\Helper;

/**
 * Class Table
 * @package Platine\Console\Output
 */
class Table
{

    /**
     * Render table data
     * @param array<int, array<int, string>> $rows
     * @param array<string, string> $styles
     * @return string
     */
    public function render(array $rows, array $styles = []): string
    {
        $table = $this->normalize($rows);
        if (empty($table)) {
            return '';
        }

        list($head, $tableRows) = $table;
        $normalizedStyles = $this->normalizeStyles($styles);
        $title = [];
        $dash = [];
        $body = [];

        list($start, $end) = $normalizedStyles['head'];
        foreach ($head as $col => $size) {
            $dash[] = str_repeat('-', (int) $size + 2);
            $title[] = str_pad(Helper::toWords($col), (int)$size, ' ');
        }

        $titleStr = '|' . $start . ' '
                . implode(' ' . $end . '|' . $start . ' ', $title)
                . ' ' . $end . '|' . PHP_EOL;

        $odd = true;
        foreach ($tableRows as $row) {
            $parts = [];
            list($start, $end) = $normalizedStyles[['even', 'odd'][(int) $odd]];
            foreach ($head as $col => $size) {
                $parts[] = str_pad(isset($row[$col]) ? $row[$col] : '', (int)$size, ' ');
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
     * @param array<int, array<int, mixed>> $rows
     * @return array<int, array<int, string>>
     */
    protected function normalize(array $rows): array
    {
        $head = reset($rows);

        if ($head === false || empty($head)) {
            return [];
        }

        if (!is_array($head)) {
            throw new InvalidArgumentException(sprintf(
                'Table rows must be an array of assoc arrays, [%s] given',
                gettype($head)
            ));
        }

        $header = array_fill_keys(array_keys($head), null);
        foreach ($rows as $i => &$row) {
            $row = array_merge($header, $row);
        }

        foreach ($header as $col => &$value) {
            $cols = array_column($rows, $col);
            $span = array_map('strlen', $cols);
            $span[] = strlen($col);
            $value = max($span);
        }

        return [$header, $rows];
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
