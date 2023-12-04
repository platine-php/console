<?php

declare(strict_types=1);

namespace Platine\Test\Console\Output;

use Platine\Console\Exception\InvalidArgumentException;
use Platine\Console\Output\Table;
use Platine\Dev\PlatineTestCase;

/**
 * Table class tests
 *
 * @group core
 * @group console
 */
class TableTest extends PlatineTestCase
{
    public function testRenderDefault(): void
    {
        $o = new Table();
        $res = $o->render([
            ['Name' => 'Java', 'ID' => '23', 'Rank' => '1'],
            ['Name' => 'CSS', 'ID' => '13', 'Rank' => '4'],
            ['Name' => 'PHP & HTML', 'ID' => '20', 'Rank' => '2'],
            ['Name' => 'C#', 'ID' => '30', 'Rank' => '3']
        ]);

        $expected = '+------------+----+------+
| Name       | ID | Rank |
+------------+----+------+
| Java       | 23 | 1    |
| CSS        | 13 | 4    |
| PHP & HTML | 20 | 2    |
| C#         | 30 | 3    |
+------------+----+------+
';

        $this->assertCommandOutput($res, $expected);
    }

    public function testRenderUsingStyle(): void
    {
        $o = new Table();
        $res = $o->render(
            [
            ['Name' => 'Java', 'ID' => '23', 'Rank' => '1'],
            ['Name' => 'CSS', 'ID' => '13', 'Rank' => '4'],
            ['Name' => 'PHP & HTML', 'ID' => '20', 'Rank' => '2'],
            ['Name' => 'C#', 'ID' => '30', 'Rank' => '3']
            ],
            ['head' => 'red']
        );

        $expected = '+------------+----+------+
|<red> Name       </end>|<red> ID </end>|<red> Rank </end>|
+------------+----+------+
| Java       | 23 | 1    |
| CSS        | 13 | 4    |
| PHP & HTML | 20 | 2    |
| C#         | 30 | 3    |
+------------+----+------+
';

        $this->assertCommandOutput($res, $expected);
    }

    public function testRenderEmpty(): void
    {
        $o = new Table();
        $res = $o->render([]);

        $this->assertEmpty($res);
    }

    public function testRenderWrongData(): void
    {
        $o = new Table();
        $this->expectException(InvalidArgumentException::class);
        $o->render([1, 2, 3]);
    }
}
