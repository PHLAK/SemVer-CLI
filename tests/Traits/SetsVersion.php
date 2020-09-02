<?php

namespace Tests\Traits;

use Symfony\Component\Console\Tester\CommandTester;

trait SetsVersion
{
    use HasHelpers;

    public function test_it_can_set_the_version(): void
    {
        $this->initializeVersion('1.3.37');

        $command = new CommandTester($this->app->find('set:version'));
        $command->execute(['value' => '4.2.42']);

        $this->assertEquals('Version set to 4.2.42' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_set_the_major_version(): void
    {
        $this->initializeVersion('1.3.37');

        $command = new CommandTester($this->app->find('set:major'));
        $command->execute(['value' => '2']);

        $this->assertEquals(
            'Version set to 2.0.0' . PHP_EOL,
            $command->getDisplay()
        );
    }

    public function test_it_can_set_the_minor_version(): void
    {
        $this->initializeVersion('1.3.37');

        $command = new CommandTester($this->app->find('set:minor'));
        $command->execute(['value' => '5']);

        $this->assertEquals('Version set to 1.5.0' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_set_the_patch_version(): void
    {
        $this->initializeVersion('1.3.37');

        $command = new CommandTester($this->app->find('set:patch'));
        $command->execute(['value' => '42']);

        $this->assertEquals('Version set to 1.3.42' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_set_the_pre_release_version(): void
    {
        $this->initializeVersion('1.3.37');

        $command = new CommandTester($this->app->find('set:pre-release'));
        $command->execute(['value' => 'beta.5']);

        $this->assertEquals('Version set to 1.3.37-beta.5' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_set_the_build_version(): void
    {
        $this->initializeVersion('1.3.37');

        $command = new CommandTester($this->app->find('set:build'));
        $command->execute(['value' => '007']);

        $this->assertEquals('Version set to 1.3.37+007' . PHP_EOL, $command->getDisplay());
    }
}
