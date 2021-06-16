<?php

declare(strict_types=1);

namespace Platine\Test\Console\Input;

use Platine\Console\Input\Argument;
use Platine\Dev\PlatineTestCase;

/**
 * Argument class tests
 *
 * @group core
 * @group console
 */
class ArgumentTest extends PlatineTestCase
{

    public function testConstructorDefault(): void
    {
        $s = new Argument('src');

        $this->assertInstanceOf(Argument::class, $s);
        $this->assertFalse($s->isRequired());
        $this->assertFalse($s->isVariadic());
        $this->assertTrue($s->isOptional());
        $this->assertEquals('src', $s->getAttributeName());
        $this->assertEquals('src', $s->getName());
        $this->assertEquals('src', $s->getRaw());
        $this->assertEmpty($s->getDescription());
        $this->assertNull($s->getDefault());
        $this->assertNull($s->getFilter());
    }

    public function testConstructorRequiredAndOptionalCheck(): void
    {
        $s = new Argument('dir', 'my desc', null, true, true);

        $this->assertTrue($s->isRequired());
        $this->assertFalse($s->isOptional());
        $this->assertEquals('my desc', $s->getDescription());
    }

    public function testConstructorWithDefault(): void
    {
        $s = new Argument('dir:tmp');

        $this->assertEquals('dir', $s->getName());
        $this->assertEquals('tmp', $s->getDefault());
    }

    public function testConstructorWithDefaultForVariadic(): void
    {
        $s = new Argument('dir:tmp+45,tmp+90', 'My desc', null, false, true, true);

        $this->assertEquals('dir', $s->getName());
        $default = $s->getDefault();
        $this->assertIsArray($default);
        $this->assertCount(2, $default);
        $this->assertEquals('tmp 45', $default[0]);
        $this->assertEquals('tmp 90', $default[1]);
    }

    public function testFilter(): void
    {
        $s = new Argument(
            'file',
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
        $s = new Argument(
            'files',
            'my desc',
            'file1',
            true,
            false,
            true
        );

        $default = $s->getDefault();
        $this->assertIsArray($default);
        $this->assertCount(1, $default);
        $this->assertEquals('file1', $default[0]);
    }


    public function testNoFilterSet(): void
    {
        $s = new Argument(
            '-p'
        );

        $this->assertEquals('foo', $s->filter('foo'));
    }
}
