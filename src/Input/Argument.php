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
 *  @file Argument.php
 *
 *  The Input Argument class
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

/**
 * Class Argument
 * @package Platine\Console\Input
 */
class Argument extends Parameter
{
    /**
     * {@inheritdoc}
     */
    public function parse(string $raw): void
    {
        $name = $raw;

        $this->name = $name;

        // Format is "name:default+value1,default+value2" ('+' => ' ')!
        if (strpos($name, ':') !== false) {
            $name = str_replace('+', ' ', $name);
            $parts = explode(':', $name, 2);
            if ($parts !== false) {
                list($this->name, $this->default) = $parts;
            }
        }

        $this->prepareDefault();
    }

    /**
     * Update default value if needed
     * @return void
     */
    protected function prepareDefault(): void
    {
        if ($this->isVariadic() && $this->default && !is_array($this->default)) {
            $this->default = explode(',', $this->default, 2);
        }
    }
}
