<?php

declare(strict_types=1);

namespace Platine\Test\Console\Input;

use Platine\Console\Exception\InvalidParameterException;
use Platine\Console\Exception\RuntimeException;
use Platine\Console\Input\Argument;
use Platine\Console\Input\Option;
use Platine\Console\Input\Parser;
use Platine\PlatineTestCase;
use Platine\Test\Fixture\Console\MyParser;

/**
 * Parser class tests
 *
 * @group core
 * @group console
 */
class ParserTest extends PlatineTestCase
{

    public function testParseEmpty(): void
    {
        $s = new MyParser();

        $argv = [];

        $s->parse($argv);

        $this->assertEmpty($s->options());
        $this->assertEmpty($s->arguments());
    }

    public function testParseValues(): void
    {
        $s = new MyParser();

        $argv = ['cmd', 'dir'];

        $s->parse($argv);

        $this->assertEmpty($s->options());
        $this->assertEmpty($s->arguments());
        $values = $s->values();

        $this->assertCount(2, $values);
        $this->assertEquals('dir', $values[0]);
    }

    public function testParseArgumentInValid(): void
    {
        $argument = $this->getMockInstance(
            Argument::class,
            ['getAttributeName' => 'foo']
        );
        $s = new MyParser();

        $this->setPropertyValue(Parser::class, $s, 'arguments', [$argument]);

        $argv = ['cmd', 'dir', '--', 'bar'];

        $s->parse($argv);

        $this->assertCount(0, $s->arguments());
        $values = $s->values(false);
        $this->assertCount(2, $values);
        $this->assertArrayHasKey('foo', $values);
        $this->assertNull($values['foo']);
    }

    public function testParseArgumentVariadic(): void
    {
        $argument = $this->getMockInstance(
            Argument::class,
            [
                    'getAttributeName' => 'foo',
                    'isVariadic' => true
                    ]
        );
        $s = new MyParser();

        $this->setPropertyValue(Parser::class, $s, 'arguments', [$argument]);

        $argv = ['cmd', 'dir1', 'dir2','dir3'];

        $s->parse($argv);

        $this->assertCount(1, $s->arguments());
        $values = $s->values(false);
        $this->assertCount(1, $values);
        $this->assertArrayHasKey('foo', $values);
        $this->assertIsArray($values['foo']);
        $this->assertCount(3, $values['foo']);
    }

    public function testParseOption(): void
    {
        $option = $this->getMockInstance(
            Option::class,
            [
                    'getAttributeName' => 'bar',
                    'is' => true
            ]
        );
        $s = new MyParser();

        $this->setPropertyValue(Parser::class, $s, 'options', [$option]);

        $argv = ['cmd', '--dir'];

        $s->parse($argv);

        $this->assertCount(1, $s->options());
        $values = $s->values(false);
        $this->assertCount(1, $values);

        $this->assertArrayHasKey('bar', $values);
        $this->assertTrue($values['bar']);
        $this->assertArrayHasKey('bar', $s->args());
    }

    public function testParseOptionVariadic(): void
    {
        $option = $this->getMockInstance(
            Option::class,
            [
                    'getAttributeName' => 'bar',
                    'isVariadic' => true,
                    'is' => true
            ]
        );
        $s = new MyParser();

        $this->setPropertyValue(Parser::class, $s, 'options', [$option]);

        $argv = ['cmd', '--dir', 'one', 'two'];

        $s->parse($argv);

        $this->assertCount(1, $s->options());
        $values = $s->values(false);
        $this->assertCount(1, $values);

        $this->assertArrayHasKey('bar', $values);
        $this->assertIsArray($values['bar']);
        $this->assertEquals('one', $values['bar'][0]);
        $this->assertEquals('two', $values['bar'][1]);
    }

    public function testParseOptionNotFound(): void
    {
        $option = $this->getMockInstance(
            Option::class,
            [
                    'getAttributeName' => 'bar',
                    'is' => false
            ]
        );
        $s = new MyParser();

        $this->setPropertyValue(Parser::class, $s, 'options', [$option]);

        $argv = ['cmd', '--dir'];

        $s->parse($argv);

        $this->assertCount(1, $s->options());
        $values = $s->values(false);
        $this->assertCount(0, $values);
    }

    public function testParseOptionListenerReturnFalse(): void
    {
        $option = $this->getMockInstance(
            Option::class,
            [
                    'getAttributeName' => 'baz',
                    'is' => true
            ]
        );
        $s = new MyParser();

        $this->setPropertyValue(Parser::class, $s, 'options', [$option]);

        $argv = ['cmd', '--dir'];

        $s->parse($argv);

        $this->assertCount(1, $s->options());
        $values = $s->values(false);
        $this->assertCount(0, $values);
    }

    public function testValidateRequired(): void
    {
        $option = $this->getMockInstance(
            Option::class,
            [
                    'getAttributeName' => 'bar',
                    'is' => true,
                    'isRequired' => true
            ]
        );
        $s = new MyParser();

        $this->setPropertyValue(Parser::class, $s, 'options', [$option]);

        $argv = ['cmd', '--dir'];
        $this->expectException(RuntimeException::class);
        $s->parse($argv);
    }

    public function testRegisterOption(): void
    {
        $option = $this->getMockInstance(
            Option::class,
            [
                'getAttributeName' => 'foo'
            ]
        );
        $s = new MyParser();

        $this->runPrivateProtectedMethod($s, 'register', [$option]);

        $this->assertCount(1, $s->options());
        $values = $s->values(false);
        $this->assertArrayHasKey('foo', $values);
        $this->assertNull($values['foo']);
    }

    public function testRegisterArgument(): void
    {
        $argument = $this->getMockInstance(
            Argument::class,
            [
                    'getAttributeName' => 'foo'
                ]
        );
        $s = new MyParser();

        $this->runPrivateProtectedMethod($s, 'register', [$argument]);

        $this->assertCount(1, $s->arguments());
        $values = $s->values(false);
        $this->assertArrayHasKey('foo', $values);
        $this->assertNull($values['foo']);
    }

    public function testUnRegisterArgument(): void
    {
        $argument = $this->getMockInstance(
            Argument::class,
            [
                    'getAttributeName' => 'foo'
                ]
        );
        $s = new MyParser();

        $this->runPrivateProtectedMethod($s, 'register', [$argument]);

        $this->assertCount(1, $s->arguments());
        $values = $s->values(false);
        $this->assertArrayHasKey('foo', $values);
        $this->assertNull($values['foo']);

        $this->runPrivateProtectedMethod($s, 'unregister', ['foo']);

        $this->assertCount(0, $s->arguments());
    }

    public function testCheckDuplicateArgument(): void
    {
        $argument = $this->getMockInstance(
            Argument::class,
            [
                    'getAttributeName' => 'foo'
                ]
        );
        $s = new MyParser();

        $this->runPrivateProtectedMethod($s, 'register', [$argument]);

        $this->assertCount(1, $s->arguments());
        $values = $s->values(false);
        $this->assertArrayHasKey('foo', $values);
        $this->assertNull($values['foo']);

        $this->expectException(InvalidParameterException::class);
        $this->runPrivateProtectedMethod($s, 'register', [$argument]);
    }

    public function testCheckDuplicateOption(): void
    {
        $option = $this->getMockInstance(
            Option::class,
            [
                    'getAttributeName' => 'foo'
                ]
        );
        $s = new MyParser();

        $this->runPrivateProtectedMethod($s, 'register', [$option]);

        $this->assertCount(1, $s->options());
        $values = $s->values(false);
        $this->assertArrayHasKey('foo', $values);
        $this->assertNull($values['foo']);

        $this->expectException(InvalidParameterException::class);
        $this->runPrivateProtectedMethod($s, 'register', [$option]);
    }
}
