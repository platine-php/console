<?php

declare(strict_types=1);

namespace Platine\Test\Console\Output;

use org\bovigo\vfs\vfsStream;
use Platine\Console\Output\Color;
use Platine\Console\Output\Cursor;
use Platine\Console\Output\Writer;
use Platine\Dev\PlatineTestCase;

/**
 * Writer class tests
 *
 * @group core
 * @group console
 */
class WriterTest extends PlatineTestCase
{
    protected $vfsRoot;
    protected $vfsPath;

    protected $vfsOutputStream;

    protected function setUp(): void
    {
        parent::setUp();
        //need setup for each test
        $this->vfsRoot = vfsStream::setup();
        $this->vfsPath = vfsStream::newDirectory('my_tests')->at($this->vfsRoot);
        $this->vfsOutputStream = $this->createVfsFileOnly('stdout', $this->vfsPath);
    }

    public function testConstructorDefault(): void
    {
        $o = new Writer($this->vfsOutputStream->url());

        $this->assertInstanceOf(Color::class, $o->getColor());
        $this->assertInstanceOf(Cursor::class, $o->getCursor());
    }
    
    public function testSetStream(): void
    {
        $o = new Writer($this->vfsOutputStream->url());
        $stream = fopen($this->vfsOutputStream->url(), 'w');
        
        $o->setStream($stream);
        $o->setErrorStream($stream);

        $this->assertEquals($stream, $this->getPropertyValue(Writer::class, $o, 'stream'));
        $this->assertEquals($stream, $this->getPropertyValue(Writer::class, $o, 'errorStream'));
    }

    public function testWriteInline(): void
    {
        $o = new Writer($this->vfsOutputStream->url());

        $text = 'Foo';
        $o->write($text);

        $expected = sprintf("\033[0;37m%s\033[0m", $text);
        $this->assertEquals($expected, $this->getOutputContent());
    }

    public function testWriteLn(): void
    {
        $o = new Writer($this->vfsOutputStream->url());

        $text = 'Foo';
        $o->write($text, true);

        $expected = sprintf("\033[0;37m%s\033[0m", $text);
        $this->assertEquals($expected . "\n", $this->getOutputContent());
    }

    public function testWriteErrorInline(): void
    {
        $o = new Writer($this->vfsOutputStream->url());

        $text = 'Foo';
        $o->writeError($text);

        $expected = sprintf("\033[0;31m%s\033[0m", $text);
        $this->assertEquals($expected, $this->getOutputContent());
    }

    public function testWriteErrorLn(): void
    {
        $o = new Writer($this->vfsOutputStream->url());

        $text = 'Foo';
        $o->writeError($text, true);

        $expected = sprintf("\033[0;31m%s\033[0m", $text);
        $this->assertEquals($expected . "\n", $this->getOutputContent());
    }

    public function testLineInline(): void
    {
        $o = new Writer($this->vfsOutputStream->url());

        $text = 'Foo';
        $o->line($text);

        $expected = sprintf("\033[0;37m%s\033[0m", $text);
        $this->assertEquals($expected, $this->getOutputContent());
    }

    public function testLineLn(): void
    {
        $o = new Writer($this->vfsOutputStream->url());

        $text = 'Foo';
        $o->line($text, true);

        $expected = sprintf("\033[0;37m%s\033[0m", $text);
        $this->assertEquals($expected . "\n", $this->getOutputContent());
    }

    public function testLineErrorInline(): void
    {
        $o = new Writer($this->vfsOutputStream->url());

        $text = 'Foo';
        $o->lineError($text);

        $expected = sprintf("\033[0;37m%s\033[0m", $text);
        $this->assertEquals($expected, $this->getOutputContent());
    }

    public function testLineErrorLn(): void
    {
        $o = new Writer($this->vfsOutputStream->url());

        $text = 'Foo';
        $o->lineError($text, true);

        $expected = sprintf("\033[0;37m%s\033[0m", $text);
        $this->assertEquals($expected . "\n", $this->getOutputContent());
    }

    public function testEol(): void
    {
        $o = new Writer($this->vfsOutputStream->url());

        $o->eol(3);

        $expected = PHP_EOL . PHP_EOL . PHP_EOL;
        $this->assertEquals($expected, $this->getOutputContent());
    }

    public function testRaw(): void
    {
        $o = new Writer($this->vfsOutputStream->url());

        $o->raw('Foo');

        $expected = 'Foo';
        $this->assertEquals($expected, $this->getOutputContent());
    }

    public function testTable(): void
    {
        $color = $this->getMockInstance(
            Color::class,
            [
                    'colors' => 'my_table',
                    'line' => 'my_table',
                    ]
        );
        $o = new Writer($this->vfsOutputStream->url(), $color);

        $o->table([
            ['Name' => 'Java', 'ID' => '23', 'Rank' => '1'],
            ['Name' => 'CSS', 'ID' => '13', 'Rank' => '4'],
            ['Name' => 'PHP & HTML', 'ID' => '20', 'Rank' => '2'],
            ['Name' => 'C#', 'ID' => '30', 'Rank' => '3']
        ]);

        $expected = 'my_table
';

        $this->assertEquals($expected, $this->getOutputContent());
    }

    /**
     * @dataProvider methodsWithOneRequiredParamProvider
     *
     * @param string $method
     * @param string $result
     * @return void
     */
    public function testMethodsWithOneRequiredParam(string $method, string $result): void
    {
        $o = new Writer($this->vfsOutputStream->url());
        $text = 'foobar';
        $o->{$method}($text);

        $res = $this->getOutputContent();

        $expected = sprintf("\033[%sm%s\033[0m", $result, $text);

        $this->assertEquals($res, $expected);
    }

    public function testFgColorLn(): void
    {
        $o = new Writer($this->vfsOutputStream->url());
        $text = 'foobar';
        $o->red($text, true);

        $res = $this->getOutputContent();

        $expected = sprintf("\033[0;31m%s\033[0m", $text);

        $this->assertEquals($res, $expected . "\n");
    }

    public function testModeColorLn(): void
    {
        $o = new Writer($this->vfsOutputStream->url());
        $text = 'foobar';
        $o->bold($text, true);

        $res = $this->getOutputContent();

        $expected = sprintf("\033[1;37m%s\033[0m", $text);

        $this->assertEquals($res, $expected . "\n");
    }

    public function testBgColorLn(): void
    {
        $o = new Writer($this->vfsOutputStream->url());
        $text = 'foobar';
        $o->bgRed($text, true);

        $res = $this->getOutputContent();

        $expected = sprintf("\033[0;37;41m%s\033[0m", $text);

        $this->assertEquals($res, $expected . "\n");
    }

    public function testColorsSame(): void
    {
        $o = new Writer($this->vfsOutputStream->url());
        $text = 'foobar';
        $o->colors($text);

        $res = $this->getOutputContent();

        $expected = $text;

        $this->assertEquals($res, $expected);
    }

    public function testColorsHtmlTag(): void
    {
        $o = new Writer($this->vfsOutputStream->url());
        $text = '<red>foobar</end>';
        $o->colors($text);

        $res = $this->getOutputContent();

        $expected = sprintf("\033[%sm%s\033[0m", '0;31', 'foobar');

        $this->assertEquals($res, $expected);
    }

    public function testColorsLn(): void
    {
        $o = new Writer($this->vfsOutputStream->url());
        $text = '<red>foobar</end>';
        $o->colors($text, true);

        $res = $this->getOutputContent();

        $expected = sprintf("\033[%sm%s\033[0m", '0;31', 'foobar');

        $this->assertEquals($res, $expected . "\n");
    }

    public function testCursorMethod(): void
    {
        $o = new Writer($this->vfsOutputStream->url());
        $res = $o->up(2);

        $this->assertEquals($res, "\e[2A");
    }


    /**
     * Data provider for "testMethodsWithOneRequiredParam"
     * @return array
     */
    public function methodsWithOneRequiredParamProvider(): array
    {
        return [
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

    /**
     * Return test output stream content
     * @return string
     */
    private function getOutputContent(): string
    {
        return $this->vfsOutputStream->getContent();
    }
}
