<?php

namespace SemVerCli\Commands;

use SemVer\SemVer;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class IncCommand extends BaseCommand {

    public function configure() {
        $this->setName('inc');
        $this->setDescription('Increment the major, minor or patch value by one');
        $this->addArgument(
            'property',
            InputArgument::REQUIRED,
            'One of: major, minor, patch'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $semver = $this->readVersionFromDisk();
        $method = $this->getMethodFromProperty('increment', $input->getArgument('property'));
        $semver->{$method}();
        $this->writeVersionToDisk($semver);
        $output->writeln('Semantic version incremented to <info>' . $semver->getVersion() . '</info>');
    }

}
