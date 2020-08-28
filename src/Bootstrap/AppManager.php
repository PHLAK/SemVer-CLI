<?php

namespace SemVerCli\Bootstrap;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;

class AppManager
{
    /** @var ContainerInterface */
    protected $container;

    /** @var Application */
    protected $app;

    /** Create a new object. */
    public function __construct(ContainerInterface $container, Application $app)
    {
        $this->container = $container;
        $this->app = $app;
    }

    /** Setup and configure the application. */
    public function __invoke(): Application
    {
        $this->app->addCommands($this->container->get('commands'));

        $this->app->getDefinition()->addOptions([
            new InputOption('adapter', 'a', InputOption::VALUE_REQUIRED, 'The storage adapter where the version data will be stsored', false),
            new InputOption('composer', 'c', InputOption::VALUE_REQUIRED, 'Path to the composer file when using the composer adpater', false),
            new InputOption('file', 'f', InputOption::VALUE_REQUIRED, 'Name of the version file when using the file adapter', false),
        ]);

        return $this->app;
    }
}
