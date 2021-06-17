<?php

declare(strict_types=1);

namespace Platine\Test\Console\Util;

use Exception;
use org\bovigo\vfs\vfsStream;
use Platine\Console\Exception\ConsoleException;
use Platine\Console\Input\Argument;
use Platine\Console\Input\Option;
use Platine\Console\Output\Writer;
use Platine\Console\Util\OutputHelper;
use Platine\Dev\PlatineTestCase;
use Platine\Test\Fixture\Console\MyColor;
use Platine\Test\Fixture\Console\MyCommand;
use Platine\Test\Fixture\Console\MyToStringClass;
use stdClass;

use function Platine\Test\Fixture\Console\printStackException;

/**
 * OutputHelper class tests
 *
 * @group core
 * @group console
 */
class OutputHelperTest extends PlatineTestCase
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
        $s = new OutputHelper();

        $this->assertInstanceOf(
            Writer::class,
            $this->getPropertyValue(OutputHelper::class, $s, 'writer')
        );
    }

    public function testConstructorCustomWriter(): void
    {
        $output = $this->vfsOutputStream->url();
        $writer = new Writer($output);

        $s = new OutputHelper($writer);

        $w = $this->getPropertyValue(OutputHelper::class, $s, 'writer');

        $this->assertInstanceOf(
            Writer::class,
            $w
        );

        $this->assertEquals($w, $writer);
    }

    public function testPrintStack(): void
    {
        $output = $this->vfsOutputStream->url();
        $color = new MyColor();

        $writer = new Writer($output, $color);

        $s = new OutputHelper($writer);

        try {
            printStackException('my exception', 34);
        } catch (Exception $ex) {
            $s->printTrace($ex);
        }

        $stdout = $this->getOutputContent();

        $this->assertEquals('{COLORS}{COLORS}', $stdout);
    }

    public function testStringifyArgs(): void
    {
        $output = $this->vfsOutputStream->url();
        $color = new MyColor();

        $writer = new Writer($output, $color);

        $s = new OutputHelper($writer);

        $args = [12, true, [45], new stdClass(), new MyToStringClass(), null];

        $res = $this->runPrivateProtectedMethod($s, 'stringifyArgs', [$args]);
        $this->assertEquals('12, true, [45], stdClass, toString, NULL', $res);
    }

    public function testPrintStackInternalException(): void
    {
        $output = $this->vfsOutputStream->url();
        $color = new MyColor();

        $writer = new Writer($output, $color);

        $s = new OutputHelper($writer);

        $s->printTrace(new class () extends ConsoleException{

        });

        $stdout = $this->getOutputContent();

        $this->assertEquals('{COLORS}', $stdout);
    }

    public function testShowArgumentsHelp(): void
    {
        $output = $this->vfsOutputStream->url();

        $color = new MyColor();

        $writer = new Writer($output, $color);

        $s = new OutputHelper($writer);

        $argument1 = $this->getMockInstance(Argument::class, [
            'getName' => 'foo',
            'getDescription' => 'foo desc',
        ]);

        $argument2 = $this->getMockInstance(Argument::class, [
            'getName' => 'bar',
            'getDescription' => 'bar desc',
        ]);

        $s->showArgumentsHelp([$argument1, $argument2], 'My header', 'My footer');

        $stdout = $this->getOutputContent();

        $this->assertEquals('[My header]

[Arguments:]
[[bar]    ][bar desc]
[[foo]    ][foo desc]

[My footer]
', $stdout);
    }

    public function testShowOptionsHelp(): void
    {
        $output = $this->vfsOutputStream->url();

        $color = new MyColor();

        $writer = new Writer($output, $color);

        $s = new OutputHelper($writer);

        $option = $this->getMockInstance(Option::class, [
            'getName' => 'foo',
            'getShort' => 'f',
            'getLong' => 'foo',
            'getDescription' => 'foo desc',
        ]);

        $s->showOptionsHelp([$option], 'My header', 'My footer');

        $stdout = $this->getOutputContent();

        $this->assertEquals('[My header]

[Options:]
[[f|foo]    ][foo desc]

[My footer]
', $stdout);
    }

    public function testShowOptionsHelpRequired(): void
    {
        $output = $this->vfsOutputStream->url();

        $color = new MyColor();

        $writer = new Writer($output, $color);

        $s = new OutputHelper($writer);

        $option = $this->getMockInstance(Option::class, [
            'getName' => 'foo',
            'getShort' => 'f',
            'getLong' => 'foo',
            'getDescription' => 'foo desc',
            'isRequired' => true,
        ]);

        $s->showOptionsHelp([$option], 'My header', 'My footer');

        $stdout = $this->getOutputContent();

        $this->assertEquals('[My header]

[Options:]
[<f|foo>    ][foo desc]

[My footer]
', $stdout);
    }

    public function testShowCommandsHelp(): void
    {
        $output = $this->vfsOutputStream->url();

        $color = new MyColor();

        $writer = new Writer($output, $color);

        $s = new OutputHelper($writer);

        $cmd = new MyCommand('My cmd', 'Cmd desc');

        $s->showCommandsHelp([$cmd], 'My header', 'My footer');

        $stdout = $this->getOutputContent();

        $this->assertEquals('[My header]

[Commands:]
[My cmd    ][Cmd desc]

[My footer]
', $stdout);
    }

    public function testShowCommandsHelpEmpty(): void
    {
        $output = $this->vfsOutputStream->url();

        $color = new MyColor();

        $writer = new Writer($output, $color);

        $s = new OutputHelper($writer);

        $s->showCommandsHelp([], 'My header', 'My footer');

        $stdout = $this->getOutputContent();

        $this->assertEquals('[My header]

[Commands:]
[  (n/a)]
', $stdout);
    }

    public function testShowUsageSimple(): void
    {
        $output = $this->vfsOutputStream->url();

        $color = new MyColor();

        $writer = new Writer($output, $color);

        $s = new OutputHelper($writer);

        $s->showUsage('My usage text', 'cmd');

        $stdout = $this->getOutputContent();

        $this->assertEquals('
[Usage Examples: ]
My usage text
', $stdout);
    }

    public function testShowUsageExplodeReturnFalse(): void
    {
        global $mock_explode_to_false;

        $mock_explode_to_false = true;
        $output = $this->vfsOutputStream->url();

        $color = new MyColor();

        $writer = new Writer($output, $color);

        $s = new OutputHelper($writer);

        $s->showUsage('My usage text ## > cd foo', 'cmd');

        $stdout = $this->getOutputContent();

        $this->assertEmpty($stdout);
    }

    public function testShowUsage(): void
    {
        $output = $this->vfsOutputStream->url();

        $color = new MyColor();

        $writer = new Writer($output, $color);

        $s = new OutputHelper($writer);

        $s->showUsage("My usage text\n Example ## cd foo", 'cmd');

        $stdout = $this->getOutputContent();

        $this->assertEquals('
[Usage Examples: ]
My usage text
 Example  # cd foo
', $stdout);
    }

    public function testShowCommandNotFound(): void
    {
        $output = $this->vfsOutputStream->url();

        $color = new MyColor();

        $writer = new Writer($output, $color);

        $s = new OutputHelper($writer);

        $s->showCommandNotFound('f', ['bar', 'fun']);

        $stdout = $this->getOutputContent();

        $this->assertEquals('[Command "f" not found]

[Did you mean fun ?]
', $stdout);
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
