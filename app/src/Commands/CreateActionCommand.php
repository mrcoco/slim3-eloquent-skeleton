<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateActionCommand  extends Command
{
    protected function configure()
    {
        $this
            ->setName('create:action')
            ->setDescription('Create an Action Class')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Name of the Class to Create'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $file = file_get_contents("resources/action_template.txt");

        $file = str_replace("!name", $name, $file);

        if (!file_exists("app/src/Action/".$name."Action.php")) {
            $fh = fopen("app/src/Action/" . $name . "Action.php", "w");
            fwrite($fh, $file);
            fclose($fh);

            $className = $name . "Action.php";

            $output->writeln("Created $className in App\\Actions");
        } else {
            $output->writeln("Class already Exists!");
        }
    }
}
