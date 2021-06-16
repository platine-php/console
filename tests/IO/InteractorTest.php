<?php

declare(strict_types=1);

namespace Platine\Test\Console\IO;

use Exception;
use org\bovigo\vfs\vfsStream;
use Platine\Console\Input\Reader;
use Platine\Console\IO\Interactor;
use Platine\Console\Output\Writer;
use Platine\Dev\PlatineTestCase;

/**
 * Interactor class tests
 *
 * @group core
 * @group console
 */
class InteractorTest extends PlatineTestCase
{

    protected $vfsRoot;
    protected $vfsPath;

    protected $vfsInputStream;
    protected $vfsOutputStream;

    protected function setUp(): void
    {
        parent::setUp();
        //need setup for each test
        $this->vfsRoot = vfsStream::setup();
        $this->vfsPath = vfsStream::newDirectory('my_tests')->at($this->vfsRoot);
        $this->vfsInputStream = $this->createVfsFileOnly('stdin', $this->vfsPath);
        $this->vfsOutputStream = $this->createVfsFileOnly('stdout', $this->vfsPath);
    }


    public function testConstructorDefault(): void
    {
        $s = new Interactor();

        $this->assertInstanceOf(Reader::class, $s->reader());
        $this->assertInstanceOf(Writer::class, $s->writer());
    }

    public function testConstructorCustomReaderAndWriter(): void
    {
        $input = $this->vfsInputStream->url();
        $output = $this->vfsOutputStream->url();

        $s = new Interactor($input, $output);

        $this->assertInstanceOf(Reader::class, $s->reader());
        $this->assertInstanceOf(Writer::class, $s->writer());
    }

    public function testConfirmYesUsingDefault(): void
    {
        $input = $this->vfsInputStream->url();
        $output = $this->vfsOutputStream->url();

        $s = new Interactor($input, $output);

        $res = $s->confirm('Are you OK');

        $this->assertTrue($res);
    }

    public function testConfirmYesUsingInputEntry(): void
    {
        $input = $this->vfsInputStream->url();
        $output = $this->vfsOutputStream->url();

        $s = new Interactor($input, $output);

        $this->createInputContent('y');

        $res = $s->confirm('Are you OK');

        $this->assertTrue($res);
    }

    public function testConfirmNo(): void
    {
        $this->createInputContent('n');

        $input = $this->vfsInputStream->url();
        $output = $this->vfsOutputStream->url();

        $s = new Interactor($input, $output);

        $res = $s->confirm('Are you OK');

        $this->assertFalse($res);
    }

    public function testChoiceUsingDefault(): void
    {
        $input = $this->vfsInputStream->url();
        $output = $this->vfsOutputStream->url();

        $s = new Interactor($input, $output);

        $res = $s->choice('Your ID ?', ['1', '4', '5'], 'TNH');

        $this->assertEquals($res, 'TNH');
    }

    public function testChoiceInvalidValueButUsingDefault(): void
    {
        $this->createInputContent('15');
        $input = $this->vfsInputStream->url();
        $output = $this->vfsOutputStream->url();

        $s = new Interactor($input, $output);

        $res = $s->choice('Your ID ?', ['1', '4', '5'], 'TNH');

        $this->assertEquals($res, 'TNH');
    }

    public function testChoiceOK(): void
    {
        $this->createInputContent('1');

        $input = $this->vfsInputStream->url();
        $output = $this->vfsOutputStream->url();

        $s = new Interactor($input, $output);

        $res = $s->choice('Your ID ?', ['1', '4', '5'], 'TNH');

        $this->assertEquals($res, '1');
    }

    public function testChoiceAssoc(): void
    {
        $this->createInputContent('one');

        $input = $this->vfsInputStream->url();
        $output = $this->vfsOutputStream->url();

        $s = new Interactor($input, $output);

        $res = $s->choice('Your ID ?', ['one' => '1', 'two' => '2'], 'one');

        $this->assertEquals($res, 'one');
    }

    public function testChoicesUsingDefault(): void
    {
        $input = $this->vfsInputStream->url();
        $output = $this->vfsOutputStream->url();

        $s = new Interactor($input, $output);

        $res = $s->choices('Your ID', ['34', '33', '100'], '23');

        $this->assertIsArray($res);
        $this->assertCount(1, $res);
        $this->assertEquals($res[0], '23');
    }

    public function testChoicesInvalidValueButUsingDefault(): void
    {
        $this->createInputContent('1');

        $input = $this->vfsInputStream->url();
        $output = $this->vfsOutputStream->url();

        $s = new Interactor($input, $output);

        $res = $s->choices('Your ID', ['34', '33', '100'], '23');

        $this->assertIsArray($res);
        $this->assertCount(1, $res);
        $this->assertEquals($res[0], '23');
    }

    public function testChoicesOK(): void
    {
        $this->createInputContent('34,100');

        $input = $this->vfsInputStream->url();
        $output = $this->vfsOutputStream->url();

        $s = new Interactor($input, $output);

        $res = $s->choices('Your ID', ['34', '33', '100'], '23');

        $this->assertIsArray($res);
        $this->assertCount(2, $res);
        $this->assertEquals($res[0], '34');
        $this->assertEquals($res[1], '100');
    }

    public function testPromptUsingDefault(): void
    {
        $input = $this->vfsInputStream->url();
        $output = $this->vfsOutputStream->url();

        $s = new Interactor($input, $output);

        $res = $s->prompt('Your name?', 'Tony');

        $this->assertEquals($res, 'Tony');
    }

    public function testPromptInvalidValue(): void
    {
        $this->createInputContent('TNH');
        $input = $this->vfsInputStream->url();
        $output = $this->vfsOutputStream->url();

        $s = new Interactor($input, $output);

        $res = $s->prompt('Your name?', 'Tony', function ($val) {
            if ($val === 'TNH') {
                throw new Exception('Invalid value');
            }
            return $val;
        });

        $this->assertEquals($res, 'Tony');
    }

    public function testPromptHiddenSuccess(): void
    {
        $this->createInputContent('TNH');

        $input = $this->vfsInputStream->url();
        $output = $this->vfsOutputStream->url();

        $s = new Interactor($input, $output);

        $res = $s->promptHidden('Your name?', null);

        $this->assertEquals($res, 'TNH');
    }

    /**
     * Return test output stream content
     * @return string
     */
    private function getOutputContent(): string
    {
        return $this->vfsOutputStream->getContent();
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
