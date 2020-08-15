<?php

use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;

class IncrementTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $command = new CommandTester($this->app->find('init'));
        $command->execute(['version' => '1.3.37']);
    }

    public function test_it_can_increment_major(): void
    {
        $command = new CommandTester($this->app->find('increment:major'));
        $command->execute([]);

        $this->assertStringContainsString('Semantic version incremented to 2.0.0', $command->getDisplay());
    }

    public function test_it_can_increment_minor(): void
    {
        $command = new CommandTester($this->app->find('increment:minor'));
        $command->execute([]);

        $this->assertStringContainsString('Semantic version incremented to 1.4.0', $command->getDisplay());
    }

    public function test_it_can_increment_patch(): void
    {
        $command = new CommandTester($this->app->find('increment:patch'));
        $command->execute([]);

        $this->assertStringContainsString('Semantic version incremented to 1.3.38', $command->getDisplay());
    }
}
