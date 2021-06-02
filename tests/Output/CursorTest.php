<?php

declare(strict_types=1);

namespace Platine\Test\Console\Output;

use Platine\Console\Output\Cursor;
use Platine\PlatineTestCase;

/**
 * Cursor class tests
 *
 * @group core
 * @group console
 */
class CursorTest extends PlatineTestCase
{

    /**
     * @dataProvider methodsWithOneParamProvider
     *
     * @param string $method
     * @param int $nb
     * @param string $result
     * @return void
     */
    public function testMethodsWithOneParam(string $method, int $nb, string $result): void
    {
        $o = new Cursor();
        $res = $o->{$method}($nb);

        $this->assertEquals($res, $result);
    }

    /**
     * @dataProvider methodsWithNoParamProvider
     *
     * @param string $method
     * @param string $result
     * @return void
     */
    public function testMethodsWithNoParam(string $method, string $result): void
    {
        $o = new Cursor();
        $res = $o->{$method}();

        $this->assertEquals($res, $result);
    }

    public function testMoveTo(): void
    {
        $o = new Cursor();
        $res = $o->moveTo(12, 178);

        $this->assertEquals($res, "\e[178;12H");
    }


    /**
     * Data provider for "testMethodsWithOneParam"
     * @return array
     */
    public function methodsWithOneParamProvider(): array
    {
        return [
           ['up', 2, "\e[2A"],
           ['up', 1, "\e[1A"],
           ['down', 4, "\e[4B"],
           ['right', 5, "\e[5C"],
           ['left', 15, "\e[15D"],
           ['next', 2, "\e[E\e[E"],
           ['prev', 1, "\e[F"],
        ];
    }

    /**
     * Data provider for "testMethodsWithNoParam"
     * @return array
     */
    public function methodsWithNoParamProvider(): array
    {
        return [
           ['eraseLine', "\e[2K"],
           ['clear', "\e[2K"],
           ['clearUp', "\e[1J"],
           ['clearDown', "\e[J"],
        ];
    }
}
