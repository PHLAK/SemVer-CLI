<?php

namespace Tests;

use DI\Container;
use DI\ContainerBuilder;
use PHLAK\SemVerCLI\Bootstrap\AppManager;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use RuntimeException;
use Symfony\Component\Console\Application;

class TestCase extends PHPUnitTestCase
{
    protected const DATA_DIR = __DIR__ . '/_data';

    protected Application $app;
    protected Container $container;

    public function setUp(): void
    {
        chdir(self::DATA_DIR);

        $this->container = (new ContainerBuilder)->addDefinitions(
            ...glob(dirname(__DIR__) . '/config/*.php')
        )->build();

        $this->container->call(AppManager::class);
        $this->app = $this->container->get(Application::class);
    }

    /** Get the file path to a test file. */
    protected function filePath(string $path = null): string
    {
        if (! is_readable($filePath = __DIR__ . '/_data/' . (string) $path)) {
            throw new RuntimeException(sprintf('File not found or not readable: %s', $filePath));
        }

        return $filePath;
    }
}
