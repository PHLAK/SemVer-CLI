<?php

namespace SemVerCli\Commands\Set;

use SemVerCli\Commands\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Minor extends Command
{
    public function configure(): void
    {
        $this->setName('set:minor');
        $this->setDescription('Set the minor version to a new value');
        $this->addArgument('value', InputArgument::REQUIRED, 'New minor version value');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->adapter->readVersion();
        $this->adapter->writeVersion(
            $version->setMinor((int) $input->getArgument('value'))
        );

        $output->writeln(
            sprintf('Version set to <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
