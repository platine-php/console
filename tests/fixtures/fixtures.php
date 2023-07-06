<?php

declare(strict_types=1);

namespace Platine\Test\Fixture\Console;

use Exception;
use Platine\Console\Command\Command;
use Platine\Console\Input\Parser;
use Platine\Console\Input\Reader;
use Platine\Console\Output\Color;
use Platine\Console\Output\Writer;

class MyCommand extends Command
{
    public function execute()
    {
        $this->io()->writer()->write('execute method');
    }

    public function interact(Reader $reader, Writer $writer): void
    {
        $writer->write('interact method');
    }

    protected function terminate(int $exitCode): void
    {
    }
}

class MyCommandExecuteThrowException extends Command
{
    public function execute()
    {
        throw new Exception('Exception message');
    }

    protected function terminate(int $exitCode): void
    {
    }
}

class MyParser extends Parser
{
    protected function emit(string $event, $value = null)
    {
        if ($event === 'baz') {
            return false;
        }

        return true;
    }

    protected function handleUnknown(string $arg, $value = null)
    {
    }
}


class MyToStringClass
{
    public function __toString(): string
    {
        return 'toString';
    }
}

class MyColor extends Color
{
    public function line(
        string $text,
        ?int $fg = self::WHITE,
        ?int $bg = null,
        ?int $mode = null
    ): string {
        return sprintf('[%s]', $text);
    }

    public function colors(string $text): string
    {
        //for printStack
        if (strpos($text, '.php') !== false) {
            return '{COLORS}';
        }

        return parent::colors($text);
    }
}

function printStackException(string $a, int $b)
{
    throw new Exception($a, $b);
}
