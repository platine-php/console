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
 *  @file Reader.php
 *
 *  The Input Reader class
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
 * Class Reader
 * @package Platine\Console\Input
 */
class Reader
{
    /**
     * The input stream
     * @var resource
     */
    protected $stream;

    /**
     * Create new instance
     * @param string|null $path the input read path
     */
    public function __construct(?string $path = null)
    {
        $stream = STDIN;
        if ($path !== null) {
            $stream = fopen($path, 'r');
        }

        $this->stream = $stream;
    }

    /**
     * Set the stream
     * @param resource $stream
     * @return $this
     */
    public function setStream($stream)
    {
        $this->stream = $stream;
        return $this;
    }


    /**
     * Read the user input
     * @param mixed $default
     * @param callable|null $callback The validator/sanitizer callback.
     * @return mixed
     */
    public function read($default = null, ?callable $callback = null)
    {
        $input = '';
        $read = fgets($this->stream);

        if ($read !== false) {
            $input = rtrim($read, "\r\n");
        }

        if ($input === '' && $default !== null) {
            return $default;
        }

        return $callback !== null
                ? $callback($input)
                : $input;
    }

    /**
     * Read all line of the user input
     * @param callable|null $callback The validator/sanitizer callback.
     * @return mixed
     */
    public function readAll(?callable $callback = null)
    {
        $input = stream_get_contents($this->stream);

        return $callback !== null
                ? $callback($input)
                : $input;
    }

    /**
     * Read content piped to the stream without waiting.
     * @param callable|null $callback The validator/sanitizer callback.
     * @return mixed
     */
    public function readPipe(?callable $callback = null)
    {
        $stdin = '';
        $read = [$this->stream];
        $write = [];
        $except = [];

        if (stream_select($read, $write, $except, 0) === 1) {
            while ($line = fgets($this->stream)) {
                $stdin .= $line;
            }
        }

        if ($stdin === '') {
            return $callback !== null
                ? $callback($this)
                : '';
        }
        return $stdin;
    }

    /**
     * Read a line from configured stream (or terminal) but don't echo it back.
     * @param mixed $default
     * @param callable|null $callback The validator/sanitizer callback.
     * @return mixed
     */
    public function readHidden($default = null, ?callable $callback = null)
    {
        if (substr(strtoupper(PHP_OS), 0, 3) === 'WIN') {
            return $this->readHiddenWindows($default, $callback);
        }

        shell_exec('stty -echo');
        $input = $this->read($default, $callback);
        shell_exec('stty echo');

        echo PHP_EOL;

        return $input;
    }

    /**
     * Read a line from configured stream (or terminal)
     *  in  windows Os but don't echo it back.
     * @param mixed $default
     * @param callable|null $callback The validation/sanitizer callback.
     * @return mixed
     */
    protected function readHiddenWindows($default = null, ?callable $callback = null)
    {
        $cmd = 'powershell -Command ' . implode('; ', array_filter([
                    '$pword = Read-Host -AsSecureString',
                    '$pword = [System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($pword)',
                    '$pword = [System.Runtime.InteropServices.Marshal]::PtrToStringAuto($pword)',
                    'echo $pword',
                ]));

        $input = '';
        $result = shell_exec($cmd);

        if ($result !== null) {
            $input = rtrim($result, "\r\n");
        }

        if ($input === '' && $default !== null) {
            return $default;
        }

        return $callback !== null
                ? $callback($input)
                : $input;
    }
}
