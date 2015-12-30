<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;



class CreateModelCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('create:model')
            ->setDescription('Create a Model Class')
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

        $file = file_get_contents("resources/model_template.txt");

        $file = str_replace("!name", $name, $file);
        $file = str_replace("?name", strtolower($name), $file);

        if (!file_exists("app/src/Model/".$name.".php")) {
            $fh = fopen("app/src/Model/" . $name . ".php", "w");
            fwrite($fh, $file);
            fclose($fh);

            $className = $name . ".php";

            $output->writeln("Created $className in App\\Model");
        } else {
            $output->writeln("Class already Exists!");
        }
    }

}

