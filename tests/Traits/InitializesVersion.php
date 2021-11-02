<?php

namespace Tests\Traits;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

trait InitializesVersion
{
    public function test_it_can_be_initialized(): void
    {
        $command = new CommandTester($this->app->find('initialize'));
        $command->execute([]);

        $this->assertStringContainsString(
            'Semantic versioning initialized to 0.1.0',
            $command->getDisplay()
        );
    }

    public function test_it_can_be_initialized_via_an_alias(): void
    {
        $command = new CommandTester($this->app->find('init'));
        $command->execute([]);

        $this->assertEquals(
            'Semantic versioning initialized to 0.1.0' . PHP_EOL,
            $command->getDisplay()
        );
    }

    public function test_it_can_be_initialized_to_a_specific_version(): void
    {
        $command = new CommandTester($this->app->find('initialize'));
        $command->execute(['version' => '1.3.37']);

        $this->assertEquals(
            'Semantic versioning initialized to 1.3.37' . PHP_EOL,
            $command->getDisplay()
        );
    }

    public function test_it_fails_to_initialize_a_partial_version(): void
    {
        $command = new CommandTester($this->app->find('initialize'));
        $command->execute(['version' => '1.2']);

        $this->assertEquals(Command::FAILURE, $command->getStatusCode());
        $this->assertEquals(
            'Invalid semantic version string provided' . PHP_EOL,
            $command->getDisplay()
        );
    }

    public function test_it_can_be_initialized_from_a_partial_version_with_the_parse_flag(): void
    {
        $command = new CommandTester($this->app->find('initialize'));
        $command->execute(['--parse' => true, 'version' => '1.2']);

        $this->assertEquals(
            'Semantic versioning initialized to 1.2.0' . PHP_EOL,
            $command->getDisplay()
        );
    }
}
