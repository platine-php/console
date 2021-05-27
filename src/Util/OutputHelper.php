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
 *  @file OutputHelper.php
 *
 *  The console output helper class
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

use Platine\Console\Command\Command;
use Platine\Console\Exception\ConsoleException;
use Platine\Console\Input\Option;
use Platine\Console\Input\Parameter;
use Platine\Console\Output\Color;
use Platine\Console\Output\Writer;
use Throwable;

/**
 * Class OutputHelper
 * @package Platine\Console\Util
 */
class OutputHelper
{

    /**
     * The writer stream instance
     * @var Writer
     */
    protected Writer $writer;

    /**
     * Max width of command name
     * @var int
     */
    protected int $maxCommandWidth = 0;

    /**
     * Create new instance
     * @param Writer|null $writer
     */
    public function __construct(?Writer $writer = null)
    {
        $this->writer = $writer ? $writer : new Writer();
    }

    /**
     * Print stack trace and error message of an exception.
     * @param Throwable $error
     * @return void
     */
    public function printTrace(Throwable $error): void
    {
        $errorClass = get_class($error);

        $this->writer->colors(sprintf(
            '%s <error>%s</end></eol> (thrown in <ok>%s</end>'
                . '<comment>:%s)</end></eol></eol>',
            $errorClass,
            $error->getMessage(),
            $error->getFile(),
            $error->getLine(),
        ));

        if ($error instanceof ConsoleException) {
            // Internal exception traces are not printed.
            return;
        }

        $traceStr = '</eol></eol><info>Stack Trace:</end></eol></eol>';
        foreach ($error->getTrace() as $i => $trace) {
            $trace += [
               'class' => '',
               'type' => '',
               'function' => '',
               'file' => '',
               'line' => '',
               'args' => []
               ];
            $symbol = $trace['class'] . $trace['type'] . $trace['function'];
            $arguments = $this->stringifyArgs($trace['args']);

            $traceStr .= ' <comment>' . $i . ')</end> <error>'
                   . $symbol . '</end><comment>(' . $arguments . ')</end>';

            if ($trace['file'] !== '') {
                $file = realpath($trace['file']);
                $traceStr .= '</eol>   <yellow>at ' . $file
                        . '</end><white>:' . $trace['line'] . '</end></eol>';
            }
        }

        $this->writer->colors($traceStr);
    }

    /**
     * Show arguments help
     * @param array<\Platine\Console\Input\Argument> $items
     * @param string $header
     * @param string $footer
     * @return $this
     */
    public function showArgumentsHelp(
        array $items,
        string $header = '',
        string $footer = ''
    ): self {
        $this->showHelp('Arguments', $items, $header, $footer);

        return $this;
    }

     /**
     * Show options help
     * @param array<Option> $items
     * @param string $header
     * @param string $footer
     * @return $this
     */
    public function showOptionsHelp(
        array $items,
        string $header = '',
        string $footer = ''
    ): self {
        $this->showHelp('Options', $items, $header, $footer);

        return $this;
    }

    /**
     * Show commands help
     * @param array<Command> $items
     * @param string $header
     * @param string $footer
     * @return $this
     */
    public function showCommandsHelp(
        array $items,
        string $header = '',
        string $footer = ''
    ): self {
        $this->maxCommandWidth = !empty($items) ? max(array_map(function (Command $item) {
            return strlen($item->getName());
        }, $items)) : 0;

        $this->showHelp('Commands', $items, $header, $footer);

        return $this;
    }

    /**
     * Show usage examples of a Command.
     * It replaces $0 with actual command name
     * and properly pads ` ## ` segments.
     * @param string $description
     * @param string $cmdName
     * @return $this
     */
    public function showUsage(string $description, string $cmdName = ''): self
    {
        $usage = str_replace('$0', $cmdName ? $cmdName : '[cmd]', $description);

        if (strpos($usage, ' ## ') === false) {
            $this->writer->eol()
                 ->green('Usage Examples: ', true, null, Color::BOLD)
                 ->colors($usage)->eol();

            return $this;
        }

        $lines = explode("\n", str_replace(
            ['</eol>', "\r\n"],
            "\n",
            $usage
        ));

        if (!is_array($lines)) {
            return $this;
        }

        foreach ($lines as $i => &$pos) {
            $replace = preg_replace('~</?\w+>~', '', $pos);
            if ($replace !== null) {
                $pos = strrpos($replace, ' ##');
            }
            if ($pos === false) {
                unset($lines[$i]);
            }
        }

        $maxLength = (int) max($lines) + 4;
        $formatedUsage = (string) preg_replace_callback(
            '~ ## ~',
            function () use (&$lines, $maxLength) {
                $sizeOfLine = 0;
                $currentLine = array_shift($lines);
                if ($currentLine !== null) {
                    $sizeOfLine = (int) $currentLine;
                }
                return str_pad('# ', $maxLength - $sizeOfLine, ' ', STR_PAD_LEFT);
            },
            $usage
        );

        $this->writer->eol()
                 ->green('Usage Examples: ', true, null, Color::BOLD)
                 ->colors($formatedUsage)->eol();

        return $this;
    }

    /**
     * Show command not found error
     * @param string $command
     * @param array<int, string> $available
     * @return $this
     */
    public function showCommandNotFound(string $command, array $available): self
    {
        $closest = [];

        foreach ($available as $cmd) {
            $lev = levenshtein($command, $cmd);
            if ($lev > 0 || $lev < 5) {
                $closest[$cmd] = $lev;
            }
        }

        $this->writer->writeError(sprintf(
            'Command "%s" not found',
            $command
        ), true);

        if (!empty($closest)) {
            asort($closest);
            $choosen = key($closest);

            $this->writer->eol()->bgRed(
                sprintf('Did you mean %s ?', $choosen),
                true
            );
        }

        return $this;
    }

    /**
     * Convert arguments to string
     * @param array<int, mixed> $args
     * @return string
     */
    protected function stringifyArgs(array $args): string
    {
        $holder = [];
        foreach ($args as $arg) {
            $holder[] = $this->stringifyArg($arg);
        }

        return implode(', ', $holder);
    }

    /**
     * Convert one argument to string
     * @param mixed $arg
     * @return string
     */
    protected function stringifyArg($arg): string
    {
        if (is_scalar($arg)) {
            return var_export($arg, true);
        }

        if (is_object($arg)) {
            return method_exists($arg, '__toString')
                    ? (string) $arg
                    : get_class($arg);
        }

        if (is_array($arg)) {
            return '[' . $this->stringifyArgs($arg) . ']';
        }

        return gettype($arg);
    }

    /**
     * Show help for given type (option, argument, command)
     * with header and footer
     * @param string $type
     * @param array<Parameter|Command> $items
     * @param string $header
     * @param string $footer
     * @return void
     */
    protected function showHelp(
        string $type,
        array $items,
        string $header = '',
        string $footer = ''
    ): void {
        if ($header) {
            $this->writer->bold($header, true);
        }

        $this->writer->eol()->green(
            $type . ':',
            true,
            null,
            Color::BOLD
        );

        if (empty($items)) {
            $this->writer->bold('  (n/a)', true);

            return;
        }

        $space = 4;
        $padLength = 0;
        foreach ($this->sortItems($items, $padLength) as $item) {
            $name = $this->getName($item);
            $desc = str_replace(
                ["\r\n", "\n"],
                str_pad("\n", $padLength + $space + 3),
                $item->getDescription()
            );

            $this->writer->bold(
                str_pad(
                    $name,
                    $padLength + $space
                ),
            );
            $this->writer->dim($desc, true);
        }

        if ($footer) {
            $this->writer->eol()->yellow($footer, true);
        }
    }

    /**
     * Sort items by name. As a side effect sets max length of all names.
     * @param array<Command|Parameter> $items
     * @param int $max
     * @return array<Command|Parameter>
     */
    protected function sortItems(array $items, int &$max = 0): array
    {
        $max = max(array_map(function ($item) {
            return strlen($this->getName($item));
        }, $items));

        uasort($items, function ($a, $b) {
            /* @var Parameter $b */
            /* @var Parameter $a */
            return $a->getName() <=> $b->getName();
        });

        return $items;
    }

    /**
     * Prepare name for different items.
     * @param Parameter|Command $item
     * @return string
     */
    protected function getName($item): string
    {
        $name = $item->getName();
        if ($item instanceof Command) {
            return trim(
                str_pad($name, $this->maxCommandWidth)
                    . ' ' . $item->getAlias()
            );
        }

        return $this->getLabel($item);
    }

    /**
     * Get parameter label for humans readable
     * @param Parameter $item
     * @return string
     */
    protected function getLabel(Parameter $item): string
    {
        $name = $item->getName();
        if ($item instanceof Option) {
            $name = $item->getShort() . '|' . $item->getLong();
        }

        $variadic = $item->isVariadic() ? '...' : '';

        if ($item->isRequired()) {
            return sprintf('<%s%s>', $name, $variadic);
        }

        return sprintf('[%s%s]', $name, $variadic);
    }
}
