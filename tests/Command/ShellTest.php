<?php

declare(strict_types=1);

namespace Platine\Test\Console\Command;

use Platine\Console\Command\Shell;
use Platine\Console\Exception\RuntimeException;
use Platine\Dev\PlatineTestCase;

/**
 * Shell class tests
 *
 * @group core
 * @group console
 */
class ShellTest extends PlatineTestCase
{


    public function testConstructorProcOpenNotExists(): void
    {
        global $mock_function_exists_to_false;
        $mock_function_exists_to_false = true;

        $this->expectException(RuntimeException::class);
        $s = new Shell('ls -l', 'foo');
    }

    public function testConstructorSuccess(): void
    {
        global $mock_function_exists_to_true;
        $mock_function_exists_to_true = true;

        $s = new Shell('ls -l', 'foo');

        $this->assertEquals(
            'ls -l',
            $this->getPropertyValue(Shell::class, $s, 'command')
        );

        $this->assertEquals(
            'foo',
            $this->getPropertyValue(Shell::class, $s, 'input')
        );
    }

    public function testSetOptions(): void
    {
        global $mock_function_exists_to_true;
        $mock_function_exists_to_true = true;

        $s = new Shell('ls -l', 'foo');

        $s->setOptions('tmp', ['FOO' => '123'], 10, []);

        $this->assertEquals(
            'tmp',
            $this->getPropertyValue(Shell::class, $s, 'cwd')
        );

        $this->assertEquals(
            10,
            $this->getPropertyValue(Shell::class, $s, 'timeout')
        );

        $envs = $this->getPropertyValue(Shell::class, $s, 'env');
        $options = $this->getPropertyValue(Shell::class, $s, 'options');

        $this->assertCount(1, $envs);
        $this->assertArrayHasKey('FOO', $envs);
        $this->assertEquals('123', $envs['FOO']);
        $this->assertEmpty($options);
    }

    public function testKill(): void
    {
        global $mock_function_exists_to_true,
                $mock_is_resource_to_true,
                $mock_proc_terminate_to_true;

        $mock_function_exists_to_true = true;
        $mock_is_resource_to_true = true;
        $mock_proc_terminate_to_true = true;

        $s = new Shell('ls -l', 'foo');

        $this->assertEquals(
            Shell::STATE_READY,
            $s->getState()
        );

        $s->kill();

        $this->assertEquals(
            Shell::STATE_TERMINATED,
            $s->getState()
        );
    }

    public function testStop(): void
    {
        global $mock_function_exists_to_true,
                $mock_is_resource_to_true,
                $mock_proc_close_to_zero,
                $mock_fclose_to_true,
                $mock_proc_get_status_to_array;

        $mock_function_exists_to_true = true;
        $mock_is_resource_to_true = true;
        $mock_proc_close_to_zero = true;
        $mock_fclose_to_true = true;
        $mock_proc_get_status_to_array = true;

        $s = new Shell('ls -l', 'foo');

        $this->setPropertyValue(Shell::class, $s, 'pipes', [[], [], []]);

        $this->assertEquals(
            Shell::STATE_READY,
            $s->getState()
        );

        $this->setPropertyValue(Shell::class, $s, 'state', Shell::STATE_STARTED);
        $this->setPropertyValue(Shell::class, $s, 'status', [
            'command' => 'cmd',
            'pid' => 1829,
            'running' => true,
            'signaled' => true,
            'stopped' => false,
            'exitcode' => 0,
            'termsig' => 034,
            'stopsig' => 134,
        ]);

        $exitCode = $s->stop();

        $this->assertEquals(0, $exitCode);

        $this->assertEquals(
            Shell::STATE_CLOSED,
            $s->getState()
        );
    }

    public function testExecute(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_true,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_array,
                $mock_stream_set_blocking_to_true;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_true = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_array = true;
        $mock_stream_set_blocking_to_true = true;

        $s = new Shell('ls -l', 'foo');

        $this->setPropertyValue(Shell::class, $s, 'pipes', [[], [], []]);

        $s->execute(true); //async

        $this->assertTrue($s->isRunning());
    }

    public function testExecuteWindows(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_true,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_array,
                $mock_stream_set_blocking_to_true,
                $mock_strtoupper_to_WIN;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_true = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_array = true;
        $mock_stream_set_blocking_to_true = true;
        $mock_strtoupper_to_WIN = true;

        $s = new Shell('ls -l', 'foo');

        $this->setPropertyValue(Shell::class, $s, 'pipes', [[], [], []]);

        $s->execute(true); //async

        $this->assertTrue($s->isRunning());
    }

    public function testExecuteBlockTimeOut(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_true,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_array,
                $mock_microtime_to_1,
                $mock_usleep_to_void;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_true = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_array = true;
        $mock_microtime_to_1 = true;
        $mock_usleep_to_void = true;

        $s = new Shell('ls -l', 'foo');

        $s->setOptions('tmp', [], -10);

        $this->setPropertyValue(Shell::class, $s, 'pipes', [[], [], []]);
        $this->setPropertyValue(Shell::class, $s, 'startTime', -109);

        $this->expectException(RuntimeException::class);
        $s->execute(false); //wait
    }

    public function testExecuteBlockTimeOutIsNull(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_true,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_array,
                $mock_microtime_to_1,
                $mock_usleep_to_void;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_true = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_array = true;
        $mock_microtime_to_1 = true;
        $mock_usleep_to_void = true;

        $s = new Shell('ls -l', 'foo');

        $s->setOptions('tmp', [], null);

        $this->setPropertyValue(Shell::class, $s, 'pipes', [[], [], []]);
        $this->setPropertyValue(Shell::class, $s, 'state', Shell::STATE_STARTED);
        $this->setPropertyValue(Shell::class, $s, 'status', [
            'command' => 'cmd',
            'pid' => 1829,
            'running' => true,
            'signaled' => true,
            'stopped' => false,
            'exitcode' => 0,
            'termsig' => 034,
            'stopsig' => 134,
        ]);

        $this->expectException(RuntimeException::class);
        $s->execute(false); //wait
    }

    public function testExecuteAlreadyRunning(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_true,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_array,
                $mock_microtime_to_1,
                $mock_usleep_to_void;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_true = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_array = true;
        $mock_microtime_to_1 = true;
        $mock_usleep_to_void = true;

        $s = new Shell('ls -l', 'foo');

        $s->setOptions('tmp', [], null);

        $this->setPropertyValue(Shell::class, $s, 'pipes', [[], [], []]);
        $this->setPropertyValue(Shell::class, $s, 'state', Shell::STATE_STARTED);
        $this->setPropertyValue(Shell::class, $s, 'status', [
            'command' => 'cmd',
            'pid' => 1829,
            'running' => true,
            'signaled' => true,
            'stopped' => false,
            'exitcode' => 0,
            'termsig' => 034,
            'stopsig' => 134,
        ]);

        $this->expectException(RuntimeException::class);
        $s->execute();
    }

    public function testExecuteBadProgram(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_false,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_array,
                $mock_stream_set_blocking_to_true;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_false = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_array = true;
        $mock_stream_set_blocking_to_true = true;

        $s = new Shell('ls -l', 'foo');

        $this->setPropertyValue(Shell::class, $s, 'pipes', [[], [], []]);

        $this->expectException(RuntimeException::class);
        $s->execute(true); //async
    }

    public function testUpdateStatusStateNotStarted(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_true,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_array,
                $mock_microtime_to_1,
                $mock_usleep_to_void;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_true = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_array = true;
        $mock_microtime_to_1 = true;
        $mock_usleep_to_void = true;

        $s = new Shell('ls -l', 'foo');

        $this->runPrivateProtectedMethod($s, 'updateStatus');

        $this->assertEquals(Shell::STATE_READY, $s->getState());
        $this->assertNull($this->getPropertyValue(Shell::class, $s, 'exitCode'));
    }

    public function testUpdateStatusProcStatusFailed(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_true,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_false,
                $mock_microtime_to_1,
                $mock_usleep_to_void;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_true = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_false = true;
        $mock_microtime_to_1 = true;
        $mock_usleep_to_void = true;

        $s = new Shell('ls -l', 'foo');

        $this->setPropertyValue(Shell::class, $s, 'state', Shell::STATE_STARTED);
        $this->expectException(RuntimeException::class);
        $this->runPrivateProtectedMethod($s, 'updateStatus');
    }

    public function testUpdateStatusSetExitCodeSuccess(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_true,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_array,
                $mock_microtime_to_1,
                $mock_usleep_to_void,
                $mock_proc_get_status_to_array_running_false;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_true = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_array = true;
        $mock_proc_get_status_to_array_running_false = true;
        $mock_microtime_to_1 = true;
        $mock_usleep_to_void = true;

        $s = new Shell('ls -l', 'foo');

        $this->setPropertyValue(Shell::class, $s, 'state', Shell::STATE_STARTED);
        $this->runPrivateProtectedMethod($s, 'updateStatus');

        $this->assertEquals(Shell::STATE_STARTED, $s->getState());
        $this->assertEquals(0, $this->getPropertyValue(Shell::class, $s, 'exitCode'));
    }

    public function testCheckTimeoutReached(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_true,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_array,
                $mock_microtime_to_1,
                $mock_usleep_to_void;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_true = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_array = true;
        $mock_microtime_to_1 = true;
        $mock_usleep_to_void = true;

        $s = new Shell('ls -l', 'foo');
        $s->setOptions('tmp', [], 1);

        $this->setPropertyValue(Shell::class, $s, 'startTime', -109);
        $this->expectException(RuntimeException::class);
        $this->runPrivateProtectedMethod($s, 'checkTimeout');
    }

    public function testCheckTimeoutAttributeIsNull(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_true,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_array,
                $mock_microtime_to_1,
                $mock_usleep_to_void;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_true = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_array = true;
        $mock_microtime_to_1 = true;
        $mock_usleep_to_void = true;

        $s = new Shell('ls -l', 'foo');

        $this->runPrivateProtectedMethod($s, 'checkTimeout');

        $this->assertNull($this->getPropertyValue(Shell::class, $s, 'timeout'));
    }

    public function testCheckTimeoutSuccess(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_true,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_array,
                $mock_microtime_to_1,
                $mock_usleep_to_void;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_true = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_array = true;
        $mock_microtime_to_1 = true;
        $mock_usleep_to_void = true;

        $s = new Shell('ls -l', 'foo');
        $s->setOptions('tmp', [], 10);

        $this->setPropertyValue(Shell::class, $s, 'state', Shell::STATE_STARTED);
        $this->setPropertyValue(Shell::class, $s, 'startTime', 0);
        $this->runPrivateProtectedMethod($s, 'checkTimeout');

        $this->assertEquals(10, $this->getPropertyValue(Shell::class, $s, 'timeout'));
    }

    public function testWaitFinished(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_true,
                $mock_fwrite_to_int;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_true = true;
        $mock_fwrite_to_int = true;

        $s = new Shell('ls -l', 'foo');

        $this->runPrivateProtectedMethod($s, 'wait');

        $this->assertNull($this->getPropertyValue(Shell::class, $s, 'exitCode'));
    }

    public function testGetErrorOutputFailed(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_false,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_array,
                $mock_stream_set_blocking_to_true,
                $mock_stream_get_contents_to_false;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_false = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_array = true;
        $mock_stream_set_blocking_to_true = true;
        $mock_stream_get_contents_to_false = true;

        $s = new Shell('ls -l', 'foo');

        $this->setPropertyValue(Shell::class, $s, 'pipes', [[], [], []]);

        $this->expectException(RuntimeException::class);
        $s->getErrorOutput();
    }

    public function testGetErrorOutputSuccess(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_false,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_array,
                $mock_stream_set_blocking_to_true,
                $mock_stream_get_contents_to_foo;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_false = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_array = true;
        $mock_stream_set_blocking_to_true = true;
        $mock_stream_get_contents_to_foo = true;

        $s = new Shell('ls -l', 'foo');

        $this->setPropertyValue(Shell::class, $s, 'pipes', [[], [], []]);

        $res = $s->getErrorOutput();

        $this->assertEquals('foo', $res);
    }

    public function testGetOutputFailed(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_false,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_array,
                $mock_stream_set_blocking_to_true,
                $mock_stream_get_contents_to_false;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_false = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_array = true;
        $mock_stream_set_blocking_to_true = true;
        $mock_stream_get_contents_to_false = true;

        $s = new Shell('ls -l', 'foo');

        $this->setPropertyValue(Shell::class, $s, 'pipes', [[], [], []]);

        $this->expectException(RuntimeException::class);
        $s->getOutput();
    }

    public function testGetOutputSuccess(): void
    {
        global $mock_function_exists_to_true,
                $mock_proc_open_to_res,
                $mock_is_resource_to_false,
                $mock_fwrite_to_int,
                $mock_proc_get_status_to_array,
                $mock_stream_set_blocking_to_true,
                $mock_stream_get_contents_to_foo;

        $mock_function_exists_to_true = true;
        $mock_proc_open_to_res = true;
        $mock_is_resource_to_false = true;
        $mock_fwrite_to_int = true;
        $mock_proc_get_status_to_array = true;
        $mock_stream_set_blocking_to_true = true;
        $mock_stream_get_contents_to_foo = true;

        $s = new Shell('ls -l', 'foo');

        $this->setPropertyValue(Shell::class, $s, 'pipes', [[], [], []]);

        $res = $s->getOutput();

        $this->assertEquals('foo', $res);
    }

    public function testGetProcessId(): void
    {
        global $mock_function_exists_to_true,
                $mock_is_resource_to_true,
                $mock_proc_close_to_zero,
                $mock_fclose_to_true,
                $mock_proc_get_status_to_array;

        $mock_function_exists_to_true = true;
        $mock_is_resource_to_true = true;
        $mock_proc_close_to_zero = true;
        $mock_fclose_to_true = true;
        $mock_proc_get_status_to_array = true;

        $s = new Shell('ls -l', 'foo');

        $this->setPropertyValue(Shell::class, $s, 'pipes', [[], [], []]);

        $this->setPropertyValue(Shell::class, $s, 'state', Shell::STATE_STARTED);
        $this->setPropertyValue(Shell::class, $s, 'status', [
            'command' => 'cmd',
            'pid' => 1829,
            'running' => true,
            'signaled' => true,
            'stopped' => false,
            'exitcode' => 0,
            'termsig' => 034,
            'stopsig' => 134,
        ]);


        $this->assertEquals(1829, $s->getProcessId());
        $this->assertEquals(0, $s->getExitCode());
    }
}
