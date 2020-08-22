<?php

namespace SemVerCli\Commands\Set;

use PHLAK\SemVer;
use SemVerCli\Traits\WritesVersion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Version extends Command
{
    use WritesVersion;

    public function configure(): void
    {
        $this->setName('set:version');
        $this->setDescription('Set the version to a new value');
        $this->addArgument('value', InputArgument::REQUIRED, 'New version value');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = new SemVer\Version($input->getArgument('value'));

        $this->writeVersion($input, $version);

        $output->writeln(
            sprintf('Version set to <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
