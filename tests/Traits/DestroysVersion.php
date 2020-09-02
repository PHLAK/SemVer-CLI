<?php

namespace Tests\Traits;

use Symfony\Component\Console\Tester\CommandTester;

trait DestroysVersion
{
    use HasHelpers;

    public function test_it_can_be_destroyed(): void
    {
        $this->initializeVersion('1.3.37');

        $command = new CommandTester($this->app->find('destroy'));
        $command->execute([]);

        $this->assertStringContainsString(
            'Semantic versioning has been disabled',
            $command->getDisplay()
        );
    }

    public function test_it_returns_an_error_when_not_initialized(): void
    {
        $command = new CommandTester($this->app->find('destroy'));
        $command->execute([]);

        $this->assertStringContainsString(
            'Semantic versioning is not intialized',
            $command->getDisplay()
        );
    }
}
