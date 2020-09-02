<?php

namespace Tests\Traits;

use Symfony\Component\Console\Tester\CommandTester;

trait IncrementsVersion
{
    public function test_it_can_increment_major(): void
    {
        $this->initializeVersion('1.3.37');

        $command = new CommandTester($this->app->find('increment:major'));
        $command->execute([]);

        $this->assertStringContainsString('Semantic version incremented to 2.0.0', $command->getDisplay());
    }

    public function test_it_can_increment_minor(): void
    {
        $this->initializeVersion('1.3.37');

        $command = new CommandTester($this->app->find('increment:minor'));
        $command->execute([]);

        $this->assertStringContainsString('Semantic version incremented to 1.4.0', $command->getDisplay());
    }

    public function test_it_can_increment_patch(): void
    {
        $this->initializeVersion('1.3.37');

        $command = new CommandTester($this->app->find('increment:patch'));
        $command->execute([]);

        $this->assertStringContainsString('Semantic version incremented to 1.3.38', $command->getDisplay());
    }
}
