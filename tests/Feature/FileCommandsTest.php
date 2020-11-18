<?php

namespace Tests\Feature;

use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;
use Tests\Traits;

/**
 * @covers \PHLAK\SemVerCLI\Adapters\FileAdapter
 * @covers \PHLAK\SemVerCLI\Commands\Command
 * @covers \PHLAK\SemVerCLI\Commands\Clear\Build
 * @covers \PHLAK\SemVerCLI\Commands\Clear\PreRelease
 * @covers \PHLAK\SemVerCLI\Commands\Destroy
 * @covers \PHLAK\SemVerCLI\Commands\Get\Build
 * @covers \PHLAK\SemVerCLI\Commands\Get\Major
 * @covers \PHLAK\SemVerCLI\Commands\Get\Minor
 * @covers \PHLAK\SemVerCLI\Commands\Get\Patch
 * @covers \PHLAK\SemVerCLI\Commands\Get\PreRelease
 * @covers \PHLAK\SemVerCLI\Commands\Get\Version
 * @covers \PHLAK\SemVerCLI\Commands\Increment\Major
 * @covers \PHLAK\SemVerCLI\Commands\Increment\Minor
 * @covers \PHLAK\SemVerCLI\Commands\Increment\Patch
 * @covers \PHLAK\SemVerCLI\Commands\Initialize
 * @covers \PHLAK\SemVerCLI\Commands\Set\Build
 * @covers \PHLAK\SemVerCLI\Commands\Set\Major
 * @covers \PHLAK\SemVerCLI\Commands\Set\Minor
 * @covers \PHLAK\SemVerCLI\Commands\Set\Patch
 * @covers \PHLAK\SemVerCLI\Commands\Set\PreRelease
 * @covers \PHLAK\SemVerCLI\Commands\Set\Version
 */
class FileCommandsTest extends TestCase
{
    use Traits\ClearsVersion;
    use Traits\DestroysVersion;
    use Traits\GetsVersion;
    use Traits\IncrementsVersion;
    use Traits\InitializesVersion;
    use Traits\SetsVersion;
    use Traits\UsesComposer;

    public function setUp(): void
    {
        parent::setUp();

        putenv('SEMVER_CLI_ADAPTER=file');
    }

    public function tearDown(): void
    {
        foreach (['VERSION', '.version'] as $versionFile) {
            if (is_file($versionFile)) {
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
        $this->assertStringEqualsFile('VERSION', '0.1.0');
    }

    public function test_it_can_override_the_version_file_name(): void
    {
        $command = new CommandTester($this->app->find('initialize'));
        $command->execute(['--file' => '.version']);

        $this->assertFileExists('.version');
        $this->assertFileDoesNotExist('VERSION');
    }
}
