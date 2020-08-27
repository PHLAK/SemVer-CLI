<?php

namespace SemVerCli\Commands\Set;

use SemVerCli\Commands\Command;
use SemVerCli\Traits\ReadsVersion;
use SemVerCli\Traits\WritesVersion;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Minor extends Command
{
    use ReadsVersion;
    use WritesVersion;

    public function configure(): void
    {
        $this->setName('set:minor');
        $this->setDescription('Set the minor version to a new value');
        $this->addArgument('value', InputArgument::REQUIRED, 'New minor version value');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->readVersion($input);
        $this->writeVersion($input, $version->setMinor($input->getArgument('value')));

        $output->writeln(
            sprintf('Version set to <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
