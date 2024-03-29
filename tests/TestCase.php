<?php

namespace Tests;

use DI\Container;
use DI\ContainerBuilder;
use PHLAK\SemVerCLI\Bootstrap\AppManager;
use RuntimeException;
use Symfony\Component\Console\Application;
use Yoast\PHPUnitPolyfills\TestCases\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected const DATA_DIR = __DIR__ . '/_data';

    protected Application $app;
    protected Container $container;

    protected function setUp(): void
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
