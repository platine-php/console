<?php

declare(strict_types=1);

namespace Platine\Test\Console\Output;

use Error;
use Platine\Console\Output\Color;
use Platine\Dev\PlatineTestCase;

/**
 * Color class tests
 *
 * @group core
 * @group console
 */
class ColorTest extends PlatineTestCase
{

    /**
     * @dataProvider methodsWithOneRequiredParamProvider
     *
     * @param string $method
     * @param string $result
     * @return void
     */
    public function testMethodsWithOneRequiredParam(string $method, string $result): void
    {
        $o = new Color();
        $text = 'foobar';
        $res = $o->{$method}($text);

        $expected = sprintf("\033[%sm%s\033[0m", $result, $text);

        $this->assertEquals($res, $expected);
    }

    public function testColorsSame(): void
    {
        $o = new Color();
        $text = 'foobar';
        $res = $o->colors($text);

        $expected = $text;

        $this->assertEquals($res, $expected);
    }

    public function testColorsHtmlTag(): void
    {
        $o = new Color();
        $text = '<red>foobar</end>';
        $res = $o->colors($text);

        $expected = sprintf("\033[%sm%s\033[0m", '0;31', 'foobar');

        $this->assertEquals($res, $expected);
    }

    public function testMagicMethodNotFound(): void
    {
        $o = new Color();
        $this->expectException(Error::class);
        $o->notfound();
    }


    /**
     * Data provider for "testMethodsWithOneRequiredParam"
     * @return array
     */
    public function methodsWithOneRequiredParamProvider(): array
    {
        return [
            //Shortcut
           ['comment', '2;37'],
           ['error', '0;31'],
           ['ok', '0;32'],
           ['warn', '0;33'],
           ['info', '0;34'],

            //Color
           ['red', '0;31'],
           ['black', '0;30'],
           ['green', '0;32'],
           ['yellow', '0;33'],
           ['blue', '0;34'],
           ['purple', '0;35'],
           ['cyan', '0;36'],
           ['white', '0;37'],
           ['gray', '0;47'],
           ['darkgray', '0;100'],

           //Background color
           ['bgRed', '0;37;41'],
           ['bgBlack', '0;37;40'],
           ['bgGreen', '0;37;42'],
           ['bgYellow', '0;37;43'],
           ['bgBlue', '0;37;44'],
           ['bgPurple', '0;37;45'],
           ['bgCyan', '0;37;46'],
           ['bgWhite', '0;37;47'],
           ['bgGray', '0;37;57'],
           ['bgDarkgray', '0;37;110'],

            //Mode
           ['bold', '1;37'],
           ['dim', '2;37'],
           ['italic', '3;37'],
           ['underline', '4;37']
        ];
    }
}
