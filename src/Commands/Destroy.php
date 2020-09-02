<?php

namespace PHLAK\SemVerCLI\Commands;

use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Destroy extends Command
{
    protected function configure(): void
    {
        $this->setName('destroy');
        $this->setDescription('Disable semantic versioning in the current path');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->adapter->destroyVersion();
        } catch (Exception $exception) {
            $output->writeln(sprintf('<comment>%s</comment>', $exception->getMessage()));

            return Command::FAILURE;
        }

        $output->writeln('Semantic versioning has been disabled');

        return Command::SUCCESS;
    }
}
