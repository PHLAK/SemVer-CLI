<?php

namespace SemVerCli\Commands;

use SemVer\SemVer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends BaseCommand {

    protected function configure() {
        $this->setName('init');
        $this->setDescription('Initialize semantic versioning in the current path');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        if (file_exists($this->semverFile)) {
            $text = '<comment>Semantic versioning already initialized in this directory</comment>';
        } else {
            $semver = new SemVer;
            file_put_contents($this->semverFile, serialize($semver), LOCK_EX);
            $text = 'Semantic versioning initialized, version set to <info>' . $semver->getVersion() . '</info>';
        }

        $output->writeln($text);

    }

}
