<?php

declare(strict_types=1);

namespace Platine\Test\Console\Input;

use Platine\Console\Input\Option;
use Platine\Dev\PlatineTestCase;

/**
 * Option class tests
 *
 * @group core
 * @group console
 */
class OptionTest extends PlatineTestCase
{

    public function testConstructorDefault(): void
    {
        $s = new Option('-p|--port');

        $this->assertInstanceOf(Option::class, $s);
        $this->assertFalse($s->isBool());
        $this->assertFalse($s->isRequired());
        $this->assertFalse($s->isVariadic());
        $this->assertTrue($s->isOptional());
        $this->assertEquals('-p', $s->getShort());
        $this->assertEquals('--port', $s->getLong());
        $this->assertEquals('port', $s->getAttributeName());
        $this->assertEquals('port', $s->getName());
        $this->assertEquals('-p|--port', $s->getRaw());
        $this->assertEmpty($s->getDescription());
        $this->assertNull($s->getDefault());
        $this->assertNull($s->getFilter());
    }

    public function testConstructorRequiredAndOptionalCheckRequiredOptionalTrue(): void
    {
        $s = new Option('-p', 'my desc', null, true, true);

        $this->assertTrue($s->isRequired());
        $this->assertFalse($s->isOptional());
        $this->assertEquals('my desc', $s->getDescription());
    }

    public function testConstructorRequiredAndOptionalCheckRequiredOptionalFalse(): void
    {
        $s = new Option('-p', 'my desc', null, false, false);

        $this->assertFalse($s->isRequired());
        $this->assertTrue($s->isOptional());
        $this->assertEquals('my desc', $s->getDescription());
    }


    public function testFilter(): void
    {
        $s = new Option(
            '-p',
            'my desc',
            null,
            true,
            false,
            false,
            function ($raw) {
                return strlen($raw);
            }
        );

        $this->assertEquals(3, $s->filter('foo'));
    }

    public function testGetDefaultForVariadic(): void
    {
        $s = new Option(
            '-p',
            'my desc',
            34,
            true,
            false,
            true
        );

        $default = $s->getDefault();
        $this->assertIsArray($default);
        $this->assertCount(1, $default);
        $this->assertEquals(34, $default[0]);
    }

    public function testIs(): void
    {
        $s = new Option(
            '-p|--port'
        );

        $this->assertFalse($s->is('foo'));
        $this->assertTrue($s->is('-p'));
        $this->assertTrue($s->is('--port'));
    }

    public function testForBoolType(): void
    {
        $s = new Option(
            '--with-foo'
        );

        $this->assertEquals('--with-foo', $s->getShort());
        $this->assertEquals('--with-foo', $s->getLong());
        $this->assertEquals('foo', $s->getName());
        $this->assertEquals('foo', $s->getAttributeName());

        $this->assertFalse($s->getDefault());

        $s1 = new Option(
            '--no-foo'
        );

        $this->assertEquals('--no-foo', $s1->getShort());
        $this->assertEquals('--no-foo', $s1->getLong());
        $this->assertEquals('foo', $s1->getName());
        $this->assertEquals('foo', $s1->getAttributeName());

        $this->assertTrue($s1->getDefault());
    }

    public function testNoFilterSet(): void
    {
        $s = new Option(
            '-p'
        );

        $this->assertEquals('foo', $s->filter('foo'));
    }
}
