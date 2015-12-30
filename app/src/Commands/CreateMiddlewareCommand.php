<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;



class CreateMiddlewareCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('create:middleware')
            ->setDescription('Create a Middleware Class')
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

        $file = file_get_contents("resources/middleware_template.txt");

        $file = str_replace("!name", $name, $file);

        if (!file_exists("app/src/Middleware/".$name."Middleware.php")) {
            $fh = fopen("app/src/Middleware/" . $name . "Middleware.php", "w");
            fwrite($fh, $file);
            fclose($fh);

            $className = $name . "Middleware.php";

            $output->writeln("Created $className in App\\Middleware");
        } else {
            $output->writeln("Class already Exists!");
        }
    }

}

