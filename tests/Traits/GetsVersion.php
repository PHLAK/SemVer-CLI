<?php

namespace Tests\Traits;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Tester\CommandTester;

trait GetsVersion
{
    use HasHelpers;

    public function test_it_can_get_the_full_version(): void
    {
        $this->initializeVersion('1.3.37-beta.5+007');

        $command = new CommandTester($this->app->find('get:version'));
        $command->execute([]);

        $this->assertEquals('1.3.37-beta.5+007' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_get_the_full_version_with_prefix(): void
    {
        $this->initializeVersion('1.3.37-beta.5+007');

        $command = new CommandTester($this->app->find('get:version'));
        $command->execute(['--prefix' => 'v']);

        $this->assertEquals('v1.3.37-beta.5+007' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_get_the_major_property(): void
    {
        $this->initializeVersion('1.3.37-beta.5+007');

        $command = new CommandTester($this->app->find('get:major'));
        $command->execute([]);

        $this->assertEquals('1' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_get_the_minor_property(): void
    {
        $this->initializeVersion('1.3.37-beta.5+007');

        $command = new CommandTester($this->app->find('get:minor'));
        $command->execute([]);

        $this->assertEquals('3' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_get_the_patch_property(): void
    {
        $this->initializeVersion('1.3.37-beta.5+007');

        $command = new CommandTester($this->app->find('get:patch'));
        $command->execute([]);

        $this->assertEquals('37' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_get_the_pre_release_property(): void
    {
        $this->initializeVersion('1.3.37-beta.5+007');

        $command = new CommandTester($this->app->find('get:pre-release'));
        $command->execute([]);

        $this->assertEquals('beta.5' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_get_the_pre_release_property_when_null(): void
    {
        $this->initializeVersion('1.3.37');

        $command = new CommandTester($this->app->find('get:pre-release'));
        $command->execute([]);

        $this->assertEquals(Command::SUCCESS, $command->getStatusCode());
        $this->assertEmpty($command->getDisplay());
    }

    public function test_it_can_get_the_pre_release_property_when_null_with_verbose_output(): void
    {
        $this->initializeVersion('1.3.37');

        $command = new CommandTester($this->app->find('get:pre-release'));
        $command->execute([], ['verbosity' => OutputInterface::VERBOSITY_VERBOSE]);

        $this->assertEquals(Command::SUCCESS, $command->getStatusCode());
        $this->assertEquals('The pre-release value is NULL' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_get_the_build_property(): void
    {
        $this->initializeVersion('1.3.37-beta.5+007');

        $command = new CommandTester($this->app->find('get:build'));
        $command->execute([]);

        $this->assertEquals('007' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_get_the_build_property_when_null(): void
    {
        $this->initializeVersion('1.3.37');

        $command = new CommandTester($this->app->find('get:build'));
        $command->execute([]);

        $this->assertEquals(Command::SUCCESS, $command->getStatusCode());
        $this->assertEmpty($command->getDisplay());
    }

    public function test_it_can_get_the_build_property_when_null_with_verbose_output(): void
    {
        $this->initializeVersion('1.3.37');

        $command = new CommandTester($this->app->find('get:build'));
        $command->execute([], ['verbosity' => OutputInterface::VERBOSITY_VERBOSE]);

        $this->assertEquals(Command::SUCCESS, $command->getStatusCode());
        $this->assertEquals('The build value is NULL' . PHP_EOL, $command->getDisplay());
    }
}
