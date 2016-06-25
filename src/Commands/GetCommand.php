<?php

namespace SemVerCli\Commands;

use SemVer\SemVer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class GetCommand extends Command {

    public function configure() {
        $this->setName('get');
        $this->setDescription('Get the current value for the specified property');
        $this->addArgument(
            'property',
            InputArgument::REQUIRED,
            'One of: version, major, minor, patch, pre-release, build'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        if (! $contents = @file_get_contents('.semver')) {
            throw new RuntimeException('Semantic versioning not intialized in this directory');
        }

        $semver = unserialize($contents);

        $property = $input->getArgument('property');

        $method = 'get' . implode('', array_map('ucfirst', explode('-', $property)));
        if (! method_exists($semver, $method)) {
            throw new InvalidArgumentException('Property "' . $property . '" is not defined');
        }

        $output->writeln($semver->{$method}());

    }

}
