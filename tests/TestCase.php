<?php

namespace Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use SemVerCli\Commands;
use SemVerCli\Commands\BaseCommand;
use Symfony\Component\Console\Application;

class TestCase extends PHPUnitTestCase
{
    protected const DATA_DIR = __DIR__ . '/_data';

    protected Application $app;

    public function setUp(): void
    {
        chdir(self::DATA_DIR);

        $this->app = new Application('Semantic versioning helper', 'TEST');

        $this->app->add(new Commands\Initialize);

        $this->app->addCommands([
            // Set
            new Commands\Set\Version,
            new Commands\Set\Major,
            new Commands\Set\Minor,
            new Commands\Set\Patch,
            new Commands\Set\PreRelease,
            new Commands\Set\Build,

            // Get
            new Commands\Get\Version,
            new Commands\Get\Major,
            new Commands\Get\Minor,
            new Commands\Get\Patch,
            new Commands\Get\PreRelease,
            new Commands\Get\Build,

            // Increment
            new Commands\Increment\Major,
            new Commands\Increment\Minor,
            new Commands\Increment\Patch,
        ]);
    }

    public function tearDown(): void
    {
        unlink(sprintf('%s/%s', self::DATA_DIR, BaseCommand::VERSION_FILE));
    }
}
