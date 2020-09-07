<?php

namespace Tests\Feature;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;
use Tests\Traits;

/**
 * @covers \PHLAK\SemVerCLI\Adapters\ComposerAdapter
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
class ComposerCommandsTest extends TestCase
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

        $this->initializeComposer();
        putenv('SEMVER_CLI_ADAPTER=composer');
    }

    public function tearDown(): void
    {
        $this->destroyComposer();

        parent::tearDown();
    }

    public function test_it_fails_to_initialze_before_composer_is_initialized(): void
    {
        $this->destroyComposer();

        $command = new CommandTester($this->app->find('initialize'));
        $command->execute([]);

        $this->assertEquals(Command::FAILURE, $command->getStatusCode());
        $this->assertEquals(
            'Composer is not initialized, run composer init first' . PHP_EOL,
            $command->getDisplay()
        );
    }
}
