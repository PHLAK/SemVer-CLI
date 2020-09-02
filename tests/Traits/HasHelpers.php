<?php

namespace Tests\Traits;

use Symfony\Component\Console\Tester\CommandTester;

trait HasHelpers
{
    /** Initialize semantic versioning in the test directory. */
    protected function initializeVersion(string $version): void
    {
        $command = new CommandTester($this->app->find('initialize'));
        $command->execute(['version' => $version]);
    }

    /** Get the file path to a test file. */
    protected function filePath(string $filePath = null): string
    {
        return realpath(dirname(__DIR__) . '/_data/' . $filePath);
    }
}
