<?php

namespace SemVerCli\Commands\Set;

use SemVerCli\Traits\ReadsVersion;
use SemVerCli\Traits\WritesVersion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Major extends Command
{
    use ReadsVersion;
    use WritesVersion;

    public function configure(): void
    {
        $this->setName('set:major');
        $this->setDescription('Set the major version to a new value');
        $this->addArgument('value', InputArgument::REQUIRED, 'New major version value');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->readVersion($input);
        $this->writeVersion($input, $version->setMajor($input->getArgument('value')));

        $output->writeln(
            sprintf('Version set to <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
