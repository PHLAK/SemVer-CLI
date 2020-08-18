<?php

namespace Tests;

use Symfony\Component\Console\Tester\CommandTester;

class ClearTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $command = new CommandTester($this->app->find('init'));
        $command->execute(['version' => '1.3.37-beta.5+007']);
    }

    public function test_it_can_clear_the_pre_release(): void
    {
        $command = new CommandTester($this->app->find('clear:pre-release'));
        $command->execute([]);

        $this->assertEquals(
            'Pre-release value has been cleared, version is now 1.3.37+007' . PHP_EOL,
            $command->getDisplay()
        );
    }

    public function test_it_can_clear_the_build_value(): void
    {
        $command = new CommandTester($this->app->find('clear:build'));
        $command->execute([]);

        $this->assertEquals(
            'Build value has been cleared, version is now 1.3.37-beta.5' . PHP_EOL,
            $command->getDisplay()
        );
    }
}
