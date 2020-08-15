<?php

use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;

class GetTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $command = new CommandTester($this->app->find('init'));
        $command->execute(['version' => '1.3.37-beta.5+007']);
    }

    public function test_it_can_get_the_full_version(): void
    {
        $command = new CommandTester($this->app->find('get:version'));
        $command->execute([]);

        $this->assertEquals('1.3.37-beta.5+007' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_get_the_full_version_with_prefix(): void
    {
        $command = new CommandTester($this->app->find('get:version'));
        $command->execute(['--prefix' => 'v']);

        $this->assertEquals('v1.3.37-beta.5+007' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_get_the_major_property(): void
    {
        $command = new CommandTester($this->app->find('get:major'));
        $command->execute([]);

        $this->assertEquals('1' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_get_the_minor_property(): void
    {
        $command = new CommandTester($this->app->find('get:minor'));
        $command->execute([]);

        $this->assertEquals('3' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_get_the_patch_property(): void
    {
        $command = new CommandTester($this->app->find('get:patch'));
        $command->execute([]);

        $this->assertEquals('37' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_get_the_pre_release_property(): void
    {
        $command = new CommandTester($this->app->find('get:pre-release'));
        $command->execute([]);

        $this->assertEquals('beta.5' . PHP_EOL, $command->getDisplay());
    }

    public function test_it_can_get_the_build_property(): void
    {
        $command = new CommandTester($this->app->find('get:build'));
        $command->execute([]);

        $this->assertEquals('007' . PHP_EOL, $command->getDisplay());
    }
}
