<?php

declare(strict_types=1);

namespace Platine\Test\Console\Util;

use Platine\Console\Input\Option;
use Platine\Console\Input\Parameter;
use Platine\Console\Util\Helper;
use Platine\Dev\PlatineTestCase;

/**
 * Helper class tests
 *
 * @group core
 * @group console
 */
class HelperTest extends PlatineTestCase
{

    /**
     * @dataProvider toCamelCaseDataProvider
     *
     * @param string $str
     * @param string $result
     * @return void
     */
    public function testToCamelCase(string $str, string $result): void
    {
        $res = Helper::toCamelCase($str);

        $this->assertEquals($res, $result);
    }

    /**
     * @dataProvider toWordsDataProvider
     *
     * @param string $str
     * @param string $result
     * @return void
     */
    public function testToWords(string $str, string $result): void
    {
        $res = Helper::toWords($str);

        $this->assertEquals($res, $result);
    }

    /**
     * @dataProvider isAssocArrayProvider
     *
     * @param array $values
     * @param bool $result
     * @return void
     */
    public function testIsAssocArray(array $values, bool $result): void
    {
        $res = Helper::isAssocArray($values);

        $this->assertEquals($res, $result);
    }

    public function testNormalizeArgumentsDefault(): void
    {
        $res = Helper::normalizeArguments(['--abc=123']);

        $this->assertCount(2, $res);
        $this->assertEquals('--abc', $res[0]);
        $this->assertEquals('123', $res[1]);

        $res1 = Helper::normalizeArguments(['-abc']);

        $this->assertCount(3, $res1);
        $this->assertEquals('-a', $res1[0]);
        $this->assertEquals('-b', $res1[1]);
        $this->assertEquals('-c', $res1[2]);

        $res2 = Helper::normalizeArguments(['-p', '123']);

        $this->assertCount(2, $res2);
        $this->assertEquals('-p', $res2[0]);
        $this->assertEquals('123', $res2[1]);

        $res3 = Helper::normalizeArguments(['-p=1']);

        $this->assertCount(2, $res3);
        $this->assertEquals('-p', $res3[0]);
        $this->assertEquals('1', $res3[1]);
    }

    public function testNormalizeArgumentsExplodeReturnFalse(): void
    {
        global $mock_explode_to_false;
        $mock_explode_to_false = true;
        $res = Helper::normalizeArguments(['--abc=123']);

        $this->assertEmpty($res);
    }

    public function testNormalizeValueOptionWithBoolType(): void
    {
        $param = $this->getMockInstance(Option::class, [
            'isBool' => true,
            'getDefault' => true,
            ]);

        $res = Helper::normalizeValue($param, 'foo');

        $this->assertFalse($res);
    }

    public function testNormalizeValueParameterIsVariadic(): void
    {
        $param = $this->getMockInstance(Parameter::class, [
            'isVariadic' => true,
            ]);

        $res = Helper::normalizeValue($param, 'foo');

        $this->assertIsArray($res);
        $this->assertCount(1, $res);
        $this->assertEquals('foo', $res[0]);
    }

    public function testNormalizeValueParameterIsRequiredValueIsNull(): void
    {
        $param = $this->getMockInstance(Parameter::class, [
            'isRequired' => true,
        ]);

        $res = Helper::normalizeValue($param, null);

        $this->assertNull($res);
    }

    public function testNormalizeValueParameterIsNotRequiredValueIsNull(): void
    {
        $param = $this->getMockInstance(Parameter::class, [
            'isRequired' => false,
        ]);

        $res = Helper::normalizeValue($param, null);

        $this->assertTrue($res);
    }

    public function testNormalizeValueParameterFilter(): void
    {
        $param = $this->getMockInstance(Parameter::class, [
            'isVariadic' => false,
            'filter' => 'foobar',
            ]);

        $res = Helper::normalizeValue($param, 'foo');

        $this->assertEquals('foobar', $res);
    }

    /**
     * Data provider for "testToCamelCase"
     * @return array
     */
    public function toCamelCaseDataProvider(): array
    {
        return [
           ['My app', 'myApp'],
           ['My_app-foo', 'myAppFoo'],
           ['My-app', 'myApp'],
        ];
    }

    /**
     * Data provider for "testToWords"
     * @return array
     */
    public function toWordsDataProvider(): array
    {
        return [
           ['My-app', 'My App'],
           ['My_app-foo', 'My App Foo'],
           ['My-app', 'My App'],
        ];
    }

    /**
     * Data provider for "testToWords"
     * @return array
     */
    public function isAssocArrayProvider(): array
    {
        return [
           [['My-app', 'My App'], false],
           [['0' => 'My-app', '3' => 'My App'], true]
        ];
    }
}
