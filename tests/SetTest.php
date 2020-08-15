<?php

use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;

class SetTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $command = new CommandTester($this->app->find('init'));
        $command->execute([]);
    }

    public function test_it_can_set_the_version(): void
    {
        $command = new CommandTester($this->app->find('set:version'));
        $command->execute(['value' => '1.3.37']);

        $this->assertEquals('Version set to 1.3.37' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_set_the_major_version(): void
    {
        $command = new CommandTester($this->app->find('set:major'));
        $command->execute(['value' => '1']);

        $this->assertEquals(
            'Version set to 1.0.0' . PHP_EOL,
            $command->getDisplay()
        );
    }

    public function test_it_can_set_the_minor_version(): void
    {
        $command = new CommandTester($this->app->find('set:minor'));
        $command->execute(['value' => '3']);

        $this->assertEquals('Version set to 0.3.0' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_set_the_patch_version(): void
    {
        $command = new CommandTester($this->app->find('set:patch'));
        $command->execute(['value' => '37']);

        $this->assertEquals('Version set to 0.1.37' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_set_the_pre_release_version(): void
    {
        $command = new CommandTester($this->app->find('set:pre-release'));
        $command->execute(['value' => 'beta.5']);

        $this->assertEquals('Version set to 0.1.0-beta.5' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_set_the_build_version(): void
    {
        $command = new CommandTester($this->app->find('set:build'));
        $command->execute(['value' => '007']);

        $this->assertEquals('Version set to 0.1.0+007' . PHP_EOL, $command->getDisplay());
    }
}
