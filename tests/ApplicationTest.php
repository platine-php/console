<?php

declare(strict_types=1);

namespace Platine\Test\Console;

use Platine\Console\Application;
use Platine\PlatineTestCase;

/**
 * Console class tests
 *
 * @group core
 * @group console
 */
class ApplicationTest extends PlatineTestCase
{

    public function testConstructor(): void
    {
        $s = new Application('My app');

        $this->assertInstanceOf(Application::class, $s);
    }
}
