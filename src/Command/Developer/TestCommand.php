<?php

namespace App\Command\Developer;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('learning:migrate')
            ->setDescription('Test command')
            ->setHelp('Test command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $command = $this->getApplication()->find('doctrine:migrations:diff');
        $argument = [
            'command' => 'doctrine:migrate:diff'
        ];
        $greetInput = new ArrayInput($argument);

        try {
            $returnCode = $command->run($greetInput, $output);
        } catch (Exception $e) {
            $io->success('No data for migration!');
            $returnCode = 1;
        }

        if ($returnCode == 0) {
            $command = $this->getApplication()->find('doctrine:migrations:migrate');
            $argument = [
                'command' => 'doctrine:migrate:migrate'
            ];
            $greetInput = new ArrayInput($argument);

            try {
                $returnCode = $command->run($greetInput, $output);
                $io->success('Migration complete!');
            } catch (\Exception $e) {
                $io->error($e->getMessage());
            }
        }

        return 0;
    }
}