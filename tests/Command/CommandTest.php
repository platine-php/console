<?php

declare(strict_types=1);

namespace Platine\Test\Console\Command;

use org\bovigo\vfs\vfsStream;
use Platine\Console\Application;
use Platine\Console\Command\Command;
use Platine\Console\Exception\InvalidParameterException;
use Platine\Console\Exception\RuntimeException;
use Platine\Console\Input\Argument;
use Platine\Console\Input\Option;
use Platine\Console\Input\Reader;
use Platine\Console\IO\Interactor;
use Platine\Console\Output\Writer;
use Platine\PlatineTestCase;
use Platine\Test\Fixture\Console\MyColor;
use Platine\Test\Fixture\Console\MyCommand;
use stdClass;

/**
 * Command class tests
 *
 * @group core
 * @group console
 */
class CommandTest extends PlatineTestCase
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

    public function testGetSetDefault(): void
    {
        $s = new Command('cmd', 'My command', false);
        $s->setAlias('i')
            ->setUsage('Usage')
            ->setVersion('1.0')
            ->setName('cmd')
            ->setDescription('My command');

        $this->assertInstanceOf(Command::class, $s);
        $this->assertEquals('cmd', $s->getName());
        $this->assertEquals('My command', $s->getDescription());
        $this->assertEquals('1.0', $s->getVersion());
        $this->assertEquals('i', $s->getAlias());
        $this->assertEquals('Usage', $s->getUsage());
        $this->assertNull($s->getApp());

        $app = $this->getMockInstance(Application::class);

        $s->bind($app);
        $this->assertInstanceOf(Application::class, $s->getApp());
        $this->assertEquals($app, $s->getApp());
    }

    public function testAddOption(): void
    {
        $s = new Command('cmd', 'My command', false);
        $s->addOption(
            '-f',
            'My option',
            'tmp',
            true,
            false,
            false,
            function ($val) {
                return $val;
            }
        );

        $options = $s->commandOptions();
        $this->assertCount(1, $options);
        $this->assertArrayHasKey('f', $options);
        $this->assertInstanceOf(Option::class, $options['f']);
        $this->assertEquals('-f', $options['f']->getName());
        $this->assertEquals('My option', $options['f']->getDescription());

        $count = 3;
         $s->on(function ($val) use (&$count) {
            $count = $val * 2;
         }, 'f');

        $s->parse(['cmd', '-f', '34']);

        $optionValue = $s->getOptionValue('f');
        $this->assertEquals('34', $optionValue);
        $this->assertEquals(68, $count);
    }

    public function testAddArgument(): void
    {
        $s = new Command('cmd', 'My command', false);
        $s->addArgument(
            'dir',
            'My argument',
            'tmp',
            true,
            false,
            false,
            function ($val) {
                return $val;
            }
        );

        $arguments = $s->arguments();
        $this->assertCount(1, $arguments);
        $this->assertArrayHasKey('dir', $arguments);
        $this->assertInstanceOf(Argument::class, $arguments['dir']);
        $this->assertEquals('dir', $arguments['dir']->getName());
        $this->assertEquals('My argument', $arguments['dir']->getDescription());

        $s->parse(['cmd', '/etc']);

        $argValue = $s->getArgumentValue('dir');
        $this->assertEquals('/etc', $argValue);
    }

    public function testAddArgumentVariadicTwice(): void
    {
        $s = new Command('cmd', 'My command', false);
        $s->addArgument(
            'dir',
            'My argument',
            'tmp',
            true,
            false,
            true,
            function ($val) {
                return $val;
            }
        );

        $this->expectException(InvalidParameterException::class);
        $s->addArgument(
            'dir',
            'My argument',
            'tmp',
            true,
            false,
            true,
            function ($val) {
                return $val;
            }
        );
    }

    public function testShowHelp(): void
    {
        $output = $this->vfsOutputStream->url();
        $color = new MyColor();
        $writer = new Writer($output, $color);

        $io = $this->getMockInstance(Interactor::class, [
            'writer' => $writer
        ]);

        $app = $this->getMockInstance(Application::class, [
            'io' => $io
        ]);

        $s = new Command('cmd', 'My command', false);
        $s->setUsage('My usage');
        $s->bind($app);

        /////// Hack to prevent exit() call ////////////
        $this->setPropertyValue(Command::class, $s, 'events', []);
        //////////////////////////////////////////////////////////////

        $s->showHelp();

        $stdout = $this->getOutputContent();

        $this->assertEquals('[Command cmd, version ]

[My command]

[Usage: ][cmd [OPTIONS...] [ARGUMENTS...]]

[Arguments:]
[  (n/a)]

[Options:]
[[-h|--help]         ][Show help]
[[-V|--verbosity]    ][Verbosity level]
[[-v|--version]      ][Show version]

[Legend: <required> [optional] variadic...]

[Usage Examples: ]
My usage
', $stdout);
    }

    public function testShowVersion(): void
    {
        $output = $this->vfsOutputStream->url();
        $color = new MyColor();
        $writer = new Writer($output, $color);

        $io = $this->getMockInstance(Interactor::class, [
            'writer' => $writer
        ]);

        $app = $this->getMockInstance(Application::class, [
            'io' => $io
        ]);

        $s = new Command('cmd', 'My command', false);
        $s->setVersion('1.4.5');
        $s->bind($app);

        $s->onExit(function (int $code) {
        });

        $s->showVersion();

        $stdout = $this->getOutputContent();

        $this->assertEquals('[cmd, 1.4.5]
', $stdout);
    }

    public function testIoAppInstanceNull(): void
    {
        $s = new Command('cmd', 'My command', false);
        $o = $this->runPrivateProtectedMethod($s, 'io');

        $this->assertInstanceOf(Interactor::class, $o);
    }

    public function testExecute(): void
    {
        $output = $this->vfsOutputStream->url();
        $color = new MyColor();
        $writer = new Writer($output, $color);

        $io = $this->getMockInstance(Interactor::class, [
            'writer' => $writer
        ]);

        $app = $this->getMockInstance(Application::class, [
            'io' => $io
        ]);

        $s = new Command('cmd', 'My command', false);
        $s->bind($app);

        $s->onExit(function (int $code) {
        });

        $s->execute();

        $stdout = $this->getOutputContent();

        $this->assertEmpty($stdout);
    }

    public function testInteract(): void
    {
        $output = $this->vfsOutputStream->url();
        $color = new MyColor();
        $writer = new Writer($output, $color);

        $io = $this->getMockInstance(Interactor::class, [
            'writer' => $writer
        ]);

        $reader = $this->getMockInstance(Reader::class);

        $app = $this->getMockInstance(Application::class, [
            'io' => $io
        ]);

        $s = new Command('cmd', 'My command', false);
        $s->bind($app);

        $s->onExit(function (int $code) {
        });

        $s->interact($reader, $writer);

        $stdout = $this->getOutputContent();

        $this->assertEmpty($stdout);
    }

    public function testTap(): void
    {
        $app = $this->getMockInstance(Application::class);

        $s = new MyCommand('cmd', 'My command', false);
        $s->bind($app);


        $this->assertInstanceOf(Application::class, $s->tap());
        $this->assertInstanceOf(stdClass::class, $s->tap(new stdClass()));
    }

    public function testHandleUnknownFalse(): void
    {
        $output = $this->vfsOutputStream->url();
        $color = new MyColor();
        $writer = new Writer($output, $color);

        $io = $this->getMockInstance(Interactor::class, [
            'writer' => $writer
        ]);

        $app = $this->getMockInstance(Application::class, [
            'io' => $io
        ]);

        $s = new MyCommand('cmd', 'My command', false);
        $s->bind($app);

        $s->onExit(function (int $code) {
        });

        $this->expectException(RuntimeException::class);
        $s->parse(['cmd', '-o']);
    }

    public function testHandleUnknownShowHelp(): void
    {
        $output = $this->vfsOutputStream->url();
        $color = new MyColor();
        $writer = new Writer($output, $color);

        $io = $this->getMockInstance(Interactor::class, [
            'writer' => $writer
        ]);

        $app = $this->getMockInstance(Application::class, [
            'io' => $io
        ]);

        $s = new MyCommand('cmd', 'My command', false);
        $s->bind($app);

        $s->onExit(function (int $code) {
        });
        $this->setPropertyValue(Command::class, $s, 'values', ['foo' => 46]);

        $this->runPrivateProtectedMethod($s, 'handleUnknown', ['foo', 'abc']);

        $this->assertTrue(true);
    }

    public function testHandleUnknownTrue(): void
    {
        $output = $this->vfsOutputStream->url();
        $color = new MyColor();
        $writer = new Writer($output, $color);

        $io = $this->getMockInstance(Interactor::class, [
            'writer' => $writer
        ]);

        $app = $this->getMockInstance(Application::class, [
            'io' => $io
        ]);

        $s = new MyCommand('cmd', 'My command', true);
        $s->bind($app);

        $s->onExit(function (int $code) {
        });

        $s->parse(['cmd', '-o', '45']);

        $values = $s->values(false);

        $this->assertIsArray($values);
        $this->assertCount(1, $values);
        $this->assertArrayHasKey('o', $values);
        $this->assertEquals('45', $values['o']);
    }


    public function testSetVerbosity(): void
    {
        $output = $this->vfsOutputStream->url();
        $color = new MyColor();
        $writer = new Writer($output, $color);

        $io = $this->getMockInstance(Interactor::class, [
            'writer' => $writer
        ]);

        $app = $this->getMockInstance(Application::class, [
            'io' => $io
        ]);

        $s = new Command('cmd', 'My command', true);
        $s->bind($app);

        $s->parse(['cmd', '-VVV']);

        $this->assertEquals(
            3,
            $this->getPropertyValue(Command::class, $s, 'verbosity')
        );
    }

    public function testOnExit(): void
    {
        $output = $this->vfsOutputStream->url();
        $color = new MyColor();
        $writer = new Writer($output, $color);

        $io = $this->getMockInstance(Interactor::class, [
            'writer' => $writer
        ]);

        $app = $this->getMockInstance(Application::class, [
            'io' => $io
        ]);

        $s = new MyCommand('cmd', 'My command', true);
        ///$s->onExit(function(int $code){});
        $s->bind($app);

        $s->showVersion();

        $s->parse(['cmd', '-h']);

        $this->assertTrue(true);
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
