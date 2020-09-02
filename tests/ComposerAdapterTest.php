<?php

namespace Tests;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class ComposerAdapterTest extends TestCase
{
    use Traits\ClearsVersion;
    use Traits\DestroysVersion;
    use Traits\GetsVersion;
    use Traits\HasHelpers;
    use Traits\IncrementsVersion;
    use Traits\InitializesVersion;
    use Traits\SetsVersion;

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

    /** Initialize Composer in the dest directory. */
    protected function initializeComposer(): void
    {
        copy($this->filePath('skeleton/composer.json'), __DIR__ . '/_data/composer.json');
    }

    /** Remove the composer.json file from the test directory. */
    protected function destroyComposer(): void
    {
        if (file_exists('composer.json')) {
            unlink('composer.json');
        }
    }
}
