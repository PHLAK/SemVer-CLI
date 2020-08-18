<?php

namespace SemVerCli\Commands\Increment;

use SemVerCli\Commands\BaseCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Patch extends BaseCommand
{
    public function configure(): void
    {
        $this->setName('increment:patch');
        $this->setDescription('Increment the patch version by one');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->readVersionFromDisk($input);
        $this->writeVersionToDisk($input, $version->incrementPatch());

        $output->writeln(
            sprintf('Semantic version incremented to <info>%s</info>', (string) $version)
        );

        return Command::SUCCESS;
    }
}
