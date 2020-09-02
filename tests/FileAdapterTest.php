<?php

namespace Tests;

use Symfony\Component\Console\Tester\CommandTester;

class FileAdapterTest extends TestCase
{
    use Traits\ClearsVersion;
    use Traits\DestroysVersion;
    use Traits\GetsVersion;
    use Traits\IncrementsVersion;
    use Traits\InitializesVersion;
    use Traits\SetsVersion;

    public function setUp(): void
    {
        parent::setUp();

        putenv('SEMVER_CLI_ADAPTER=file');
    }

    public function tearDown(): void
    {
        foreach (['VERSION', '.version'] as $versionFile) {
            if (file_exists($versionFile)) {
                unlink($versionFile);
            }
        }

        parent::tearDown();
    }

    public function test_it_creates_a_version_file_when_initialized(): void
    {
        $command = new CommandTester($this->app->find('initialize'));
        $command->execute([]);

        $this->assertFileExists('VERSION');
    }

    public function test_it_can_override_the_version_file_name(): void
    {
        $command = new CommandTester($this->app->find('initialize'));
        $command->execute(['--file' => '.version']);

        $this->assertFileExists('.version');
        $this->assertFileDoesNotExist('VERSION');
    }
}
