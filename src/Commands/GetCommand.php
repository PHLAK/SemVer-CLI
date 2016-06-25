<?php

namespace SemVerCli\Commands;

use SemVer\SemVer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetCommand extends BaseCommand {

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
        $semver = $this->readVersionFromDisk();
        $method = $this->getMethodFromProperty('get', $input->getArgument('property'));
        $output->writeln($semver->{$method}());
    }

}
