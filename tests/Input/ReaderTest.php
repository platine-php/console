<?php

declare(strict_types=1);

namespace Platine\Test\Console\Input;

use org\bovigo\vfs\vfsStream;
use Platine\Console\Input\Reader;
use Platine\Dev\PlatineTestCase;

/**
 * Reader class tests
 *
 * @group core
 * @group console
 */
class ReaderTest extends PlatineTestCase
{
    protected $vfsRoot;
    protected $vfsPath;

    protected $vfsInputStream;

    protected function setUp(): void
    {
        parent::setUp();
        //need setup for each test
        $this->vfsRoot = vfsStream::setup();
        $this->vfsPath = vfsStream::newDirectory('my_tests')->at($this->vfsRoot);
        $this->vfsInputStream = $this->createVfsFileOnly('stdin', $this->vfsPath);
    }

    public function testConstructorDefault(): void
    {
        $o = new Reader($this->vfsInputStream->url());

        $this->assertInstanceOf(Reader::class, $o);
    }

    public function testSetStream(): void
    {
        $o = new Reader($this->vfsInputStream->url());
        $stream = fopen($this->vfsInputStream->url(), 'r');

        $o->setStream($stream);

        $this->assertEquals($stream, $this->getPropertyValue(Reader::class, $o, 'stream'));
    }

    public function testReadSimple(): void
    {
        $text = 'tnh';
        $this->createInputContent($text);

        $o = new Reader($this->vfsInputStream->url());
        $this->assertEquals($text, $o->read());
    }

    public function testReadUsingDefautlValue(): void
    {

        $o = new Reader($this->vfsInputStream->url());
        $this->assertEquals('foo', $o->read('foo'));
    }

    public function testReadWithCallaback(): void
    {
        $text = 'tnh';
        $this->createInputContent($text);

        $o = new Reader($this->vfsInputStream->url());
        $this->assertEquals(3, $o->read(null, function ($val) {
            return strlen($val);
        }));
    }

    public function testReadAll(): void
    {
        $text = "tnh\nfoo";
        $this->createInputContent($text);

        $o = new Reader($this->vfsInputStream->url());
        $this->assertEquals($text, $o->readAll());
    }

    public function testReadAllWithCallback(): void
    {
        $text = "tnh\nfoo";
        $this->createInputContent($text);

        $o = new Reader($this->vfsInputStream->url());
        $this->assertEquals(7, $o->readAll(function ($val) {
            return strlen($val);
        }));
        $this->createInputContent($text);
    }


    public function testReadPipeUsingCallabck(): void
    {
        global $mock_stream_select_to_one;

        $mock_stream_select_to_one = true;

        $o = new Reader($this->vfsInputStream->url());
        $res = $o->readPipe(function ($val) {
            return 'tnh';
        });
        $this->assertEquals('tnh', $res);
    }

    public function testReadPipe(): void
    {
        global $mock_stream_select_to_one;

        $mock_stream_select_to_one = true;

        $text = "tnh";
        $this->createInputContent($text);

        $o = new Reader($this->vfsInputStream->url());
        $res = $o->readPipe();
        $this->assertEquals($text, $res);
    }

    public function testReadHiddenWindowsDefaultValue(): void
    {
        global $mock_strtoupper_to_WIN,
               $mock_shell_exec_to_null;

        $mock_strtoupper_to_WIN = true;
        $mock_shell_exec_to_null = true;

        $text = 'tnh';
        $this->createInputContent($text);

        $o = new Reader($this->vfsInputStream->url());
        $this->assertEquals('foo', $o->readHidden('foo'));
    }

    public function testReadHiddenWindowsSuccess(): void
    {
        global $mock_strtoupper_to_WIN,
               $mock_shell_exec_to_foo;

        $mock_strtoupper_to_WIN = true;
        $mock_shell_exec_to_foo = true;

        $text = 'tnh';
        $this->createInputContent($text);

        $o = new Reader($this->vfsInputStream->url());
        $this->assertEquals('foo', $o->readHidden());
    }

    public function testReadHiddenWindowsWithCallback(): void
    {
        global $mock_strtoupper_to_WIN,
               $mock_shell_exec_to_foo;

        $mock_strtoupper_to_WIN = true;
        $mock_shell_exec_to_foo = true;

        $text = 'tnh';
        $this->createInputContent($text);

        $o = new Reader($this->vfsInputStream->url());
        $this->assertEquals(3, $o->readHidden(null, function ($val) {
            return strlen($val);
        }));
    }

    public function testReadHidden(): void
    {
        global $mock_shell_exec_to_foo;
        $mock_shell_exec_to_foo = true;
        $text = 'foo';
        $this->createInputContent($text);

        $o = new Reader($this->vfsInputStream->url());
        $this->assertEquals($text, $o->readHidden());
    }

    public function testReadHiddenDefaultValue(): void
    {
        global $mock_shell_exec_to_foo;
        $mock_shell_exec_to_foo = true;

        $o = new Reader($this->vfsInputStream->url());
        $this->assertEquals('foo', $o->readHidden('foo'));
    }

    public function testReadHiddenWithCallaback(): void
    {
        global $mock_shell_exec_to_foo;
        $mock_shell_exec_to_foo = true;

        $text = 'tnh';
        $this->createInputContent($text);

        $o = new Reader($this->vfsInputStream->url());
        $this->assertEquals(3, $o->readHidden(null, function ($val) {
            return strlen($val);
        }));
    }

    /**
     * Write to test input stream
     * @return void
     */
    private function createInputContent(string $text): void
    {
        file_put_contents($this->vfsInputStream->url(), $text);
    }
}
