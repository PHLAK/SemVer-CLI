<?php

namespace SemVerCli\Bootstrap;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;

class AppManager
{
    protected ContainerInterface $container;
    protected Application $app;

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

        $this->app->getDefinition()->addOption(
            new InputOption('file', 'f', InputOption::VALUE_REQUIRED, 'Name of the version file', 'VERSION')
        );

        return $this->app;
    }
}
