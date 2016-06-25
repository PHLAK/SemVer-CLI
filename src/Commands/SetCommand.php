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

class SetCommand extends Command {

    public function configure() {
        $this->setName('set');
        $this->setDescription('Set a new value for the sepcified property');
        $this->addArgument(
            'property',
            InputArgument::REQUIRED,
            'One of: major, minor, patch, pre-release, build'
        );
        $this->addArgument(
            'value',
            InputArgument::REQUIRED,
            'New property value'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        if (! $contents = @file_get_contents('.semver')) {
            throw new RuntimeException('Semantic versioning not intialized in this directory');
        }

        $semver = unserialize($contents);

        $property = $input->getArgument('property');

        $method = 'set' . implode('', array_map('ucfirst', explode('-', $property)));
        if (! method_exists($semver, $method)) {
            throw new InvalidArgumentException('Property "' . $property . '" is not defined');
        }

        $semver->{$method}($input->getArgument('value'));

        if (file_put_contents('.semver', serialize($semver), LOCK_EX) === false) {
            throw new RuntimeException('Failed to write data to disk');
        }

        $output->writeln('Semantic version set to <info>' . $semver->getVersion() . '</info>');

    }

}
