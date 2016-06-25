<?php

namespace SemVerCli\Commands;

use SemVer\SemVer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetCommand extends BaseCommand {

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
        $semver = $this->readVersionFromDisk();
        $method = $this->getMethodFromProperty('set', $input->getArgument('property'));
        $semver->{$method}($input->getArgument('value'));
        $this->writeVersionToDisk($semver);
        $output->writeln('Semantic version set to <info>' . $semver->getVersion() . '</info>');
    }

}
