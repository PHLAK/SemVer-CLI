<?php

namespace Tests;

use DI\Container;
use DI\ContainerBuilder;
use PHLAK\SemVerCLI\Bootstrap\AppManager;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
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
}
