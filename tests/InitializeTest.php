<?php

use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;

class InitializeTest extends TestCase
{
    public function test_it_can_be_initialized(): void
    {
        $command = new CommandTester($this->app->find('initialize'));
        $command->execute([]);

        $this->assertStringContainsString(
            'Semantic versioning initialized, version set to 0.1.0',
            $command->getDisplay()
        );
    }

    public function test_it_can_be_initialized_with_an_alias(): void
    {
        $command = new CommandTester($this->app->find('init'));
        $command->execute([]);

        $this->assertEquals(
            'Semantic versioning initialized, version set to 0.1.0' . PHP_EOL,
            $command->getDisplay()
        );
    }

    public function test_it_can_be_initialized_to_a_specific_version(): void
    {
        $command = new CommandTester($this->app->find('init'));
        $command->execute(['version' => '1.3.37']);

        $this->assertEquals(
            'Semantic versioning initialized, version set to 1.3.37' . PHP_EOL,
            $command->getDisplay()
        );
    }
}
