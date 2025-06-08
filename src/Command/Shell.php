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
 *  @file Shell.php
 *
 *  The shell class
 *
 *  @package    Platine\Console\Command
 *  @author Platine Developers Team
 *  @copyright  Copyright (c) 2020
 *  @license    http://opensource.org/licenses/MIT  MIT License
 *  @link   https://www.platine-php.com
 *  @version 1.0.0
 *  @filesource
 */

declare(strict_types=1);

namespace Platine\Console\Command;

use Platine\Console\Exception\RuntimeException;

/**
 * @class Shell
 * @package Platine\Console\Command
 */
class Shell
{
    public const STDIN_DESCRIPTOR = 0;
    public const STDOUT_DESCRIPTOR = 1;
    public const STDERR_DESCRIPTOR = 2;

    public const STATE_READY = 0;
    public const STATE_STARTED = 1;
    public const STATE_CLOSED = 2;
    public const STATE_TERMINATED = 3;

    /**
     * Whether to wait for the process to finish or return instantly
     * @var bool
     */
    protected bool $async = false;

    /**
     * The command to execute
     * @var string
     */
    protected string $command = '';

    /**
     * Current working directory
     * @var string|null
     */
    protected ?string $cwd = null;

    /**
     * The list of descriptors to pass to process
     * @var array<int, array<int, string>>
     */
    protected array $descriptors = [];

    /**
     * List of environment variables
     * @var array<string, mixed>|null
     */
    protected ?array $env = null;

    /**
     * The process exit code
     * @var int|null
     */
    protected ?int $exitCode = null;

    /**
     * The path for input stream
     * @var string|null
     */
    protected ?string $input = null;

    /**
     * Others options to pass to process
     * @var array<string, mixed>
     */
    protected array $options = [];

    /**
     * Pointers to standard input/output/error
     * @var array<int, resource>
     */
    protected array $pipes = [];

    /**
     * The actual process resource returned
     * @var resource|false
     */
    protected $process;

    /**
     * The process start time in Unix timestamp
     * @var float
     */
    protected float $startTime = 0;

    /**
     * Default timeout for the process in seconds with microseconds
     * @var float|null
     */
    protected ?float $timeout = null;

    /**
     * The status list of the process
     * @var array<string, mixed>
     */
    protected array $status = [];

    /**
     * The current process status
     * @var int
     */
    protected int $state = self::STATE_READY;

    /**
     * Create new instance
     */
    public function __construct()
    {
        if (!function_exists('proc_open')) {
            throw new RuntimeException(
                'The "proc_open" could not be found in your PHP setup'
            );
        }
    }

    /**
     * Set the command to be executed
     * @param string $command
     * @return $this
     */
    public function setCommand(string $command): self
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Set the input stream information
     * @param string|null $input
     * @return $this
     */
    public function setInput(?string $input): self
    {
        $this->input = $input;
        return $this;
    }

    /**
     * Whether the process is running
     * @return bool
     */
    public function isRunning(): bool
    {
        if ($this->state !== self::STATE_STARTED) {
            return false;
        }

        $this->updateStatus();

        return $this->status['running'];
    }

    /**
     * Kill the process
     * @return void
     */
    public function kill(): void
    {
        if (is_resource($this->process)) {
            proc_terminate($this->process);
        }

        $this->state = self::STATE_TERMINATED;
    }

    /**
     * Stop the process
     * @return int|null
     */
    public function stop(): ?int
    {
        $this->closePipes();

        if (is_resource($this->process)) {
            proc_close($this->process);
        }

        $this->state = self::STATE_CLOSED;
        $this->exitCode = $this->status['exitcode'];

        return $this->exitCode;
    }

    /**
     * Set options used for process execution
     * @param string|null $cwd
     * @param array<string, mixed>|null $env
     * @param float|null $timeout
     * @param array<string, mixed> $options
     * @return $this
     */
    public function setOptions(
        ?string $cwd = null,
        ?array $env = [],
        ?float $timeout = null,
        array $options = []
    ): self {
        $this->cwd = $cwd;
        $this->env = $env;
        $this->timeout = $timeout;
        $this->options = $options;

        return $this;
    }

    /**
     * Execute the process
     * @param bool $async
     * @return $this
     */
    public function execute(bool $async = false): self
    {
        if ($this->isRunning()) {
            throw new RuntimeException(sprintf(
                'Process [%s] already running',
                $this->command
            ));
        }

        $this->descriptors = $this->getDescriptors();
        $this->startTime = microtime(true);

        $this->process = proc_open(
            $this->command,
            $this->descriptors,
            $this->pipes,
            $this->cwd,
            $this->env,
            $this->options
        );

        $this->writeInput();

        if (is_resource($this->process) === false) {
            throw new RuntimeException(sprintf(
                'Bad program [%s] could not be started',
                $this->command
            ));
        }

        $this->state = self::STATE_STARTED;

        $this->updateStatus();

        $this->async = $async;

        if ($this->async) {
            $this->setOutputStreamNonBlocking();
        } else {
            $this->wait();
        }

        return $this;
    }

    /**
     * Return the process current state
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * Return the process command error output
     * @param int|null $length
     * @param int $offset
     * @return string
     * @throws RuntimeException
     */
    public function getErrorOutput(?int $length = null, int $offset = -1): string
    {
        $output = stream_get_contents(
            $this->pipes[self::STDERR_DESCRIPTOR],
            $length,
            $offset
        );

        if ($output === false) {
            throw new RuntimeException(sprintf(
                'Can not get process [%s] error output',
                $this->command
            ));
        }

        return $output;
    }

    /**
     * Return the process command output
     * @param int|null $length
     * @param int $offset
     * @return string
     * @throws RuntimeException
     */
    public function getOutput(?int $length = null, int $offset = -1): string
    {
        $output = stream_get_contents(
            $this->pipes[self::STDOUT_DESCRIPTOR],
            $length,
            $offset
        );

        if ($output === false) {
            throw new RuntimeException(sprintf(
                'Can not get process [%s] error output',
                $this->command
            ));
        }

        return $output;
    }

    /**
     * Return the process exit code
     * @return int|null
     */
    public function getExitCode(): ?int
    {
        $this->updateStatus();

        return $this->exitCode;
    }

    /**
     * Return the process ID
     * @return int|null
     */
    public function getProcessId(): ?int
    {
        return $this->isRunning() ? $this->status['pid'] : null;
    }

    /**
     * Return the descriptors to be used later
     * @return array<int, array<int, string>>
     */
    protected function getDescriptors(): array
    {
        $out = $this->isWindows()
               ? ['pipe', 'w'] // ['file', 'NUL', 'w']
               : ['pipe', 'w'];

        return [
         self::STDIN_DESCRIPTOR  => ['pipe', 'r'],
         self::STDOUT_DESCRIPTOR => $out,
         self::STDERR_DESCRIPTOR => $out,
        ];
    }

    /**
     * Whether the current Os is Windows
     * @return bool
     */
    protected function isWindows(): bool
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    /**
     * Write to input stream
     * @return void
     */
    protected function writeInput(): void
    {
        if ($this->input !== null) {
            fwrite($this->pipes[self::STDIN_DESCRIPTOR], $this->input);
        }
    }

    /**
     * Update the process status
     * @return void
     */
    protected function updateStatus(): void
    {
        if ($this->state !== self::STATE_STARTED) {
            return;
        }

        if (is_resource($this->process)) {
            $status = proc_get_status($this->process);
            if ($status === false) {
                throw new RuntimeException(sprintf(
                    'Can not get process [%s] status information',
                    $this->command
                ));
            }

            $this->status = $status;

            if ($this->status['running'] === false && $this->exitCode === null) {
                $this->exitCode = $this->status['exitcode'];
            }
        }
    }

    /**
     * Close the process pipes
     * @return void
     */
    protected function closePipes(): void
    {
        fclose($this->pipes[self::STDIN_DESCRIPTOR]);
        fclose($this->pipes[self::STDOUT_DESCRIPTOR]);
        fclose($this->pipes[self::STDERR_DESCRIPTOR]);
    }

    /**
     * Waiting the process to finish
     * @return int|null
     */
    protected function wait(): ?int
    {
        while ($this->isRunning()) {
            usleep(5000);
            $this->checkTimeout();
        }

        return $this->exitCode;
    }

    /**
     * Check for process execution timeout
     * @return void
     */
    protected function checkTimeout(): void
    {
        if ($this->timeout === null) {
            return;
        }

        $duration = microtime(true) - $this->startTime;

        if ($duration > $this->timeout) {
            throw new RuntimeException(sprintf(
                'Process [%s] execution timeout, time [%d sec] expected [%d sec]',
                $this->command,
                $duration,
                $this->timeout
            ));
        }
    }

    /**
     * Set the running process to asynchronous
     * @return bool
     */
    protected function setOutputStreamNonBlocking(): bool
    {
        return stream_set_blocking($this->pipes[self::STDOUT_DESCRIPTOR], false);
    }
}
