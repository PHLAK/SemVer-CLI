<?php

namespace Tests\Traits;

use RuntimeException;
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
    protected function filePath(string $path = null): string
    {
        if (! is_readable($filePath = dirname(__DIR__) . '/_data/' . (string) $path)) {
            throw new RuntimeException(sprintf('File not found or not readable: %s', $filePath));
        }

        return $filePath;
    }
}
