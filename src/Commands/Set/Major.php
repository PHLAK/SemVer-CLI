<?php

namespace SemVerCli\Commands\Set;

use SemVerCli\Commands\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Major extends Command
{
    public function configure(): void
    {
        $this->setName('set:major');
        $this->setDescription('Set the major version to a new value');
        $this->addArgument('value', InputArgument::REQUIRED, 'New major version value');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->adapter->readVersion();
        $this->adapter->writeVersion(
            $version->setMajor((int) $input->getArgument('value'))
        );

        $output->writeln(
            sprintf('Version set to <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
