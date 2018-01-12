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
        $directory = "app/src/Model/";
        $file = file_get_contents("resources/model_template.txt");

        $file = str_replace("!name", ucfirst($name), $file);
        $file = str_replace("?name", strtolower($name), $file);

        if (is_dir($directory) && !is_writable($directory)) {
            $output->writeln('The "%s" directory is not writable');
            return;
        }
        if (!is_dir($directory)) {
            $dialog = $this->getHelper('dialog');

            $question = new ConfirmationQuestion('<question>Directory doesn\'t exist. Would you like to try to create it?</question>', false);

            if (!$dialog->ask($input, $output, $question)) {
                return;
            }


            @mkdir($directory);
            if (!is_dir($directory)) {
                $output->writeln('<error>Couldn\'t create directory.</error>');
                return;
            }
        }

        if (!file_exists($directory.ucfirst($name).".php")) {
            $fh = fopen($directory . ucfirst($name) . ".php", "w");
            fwrite($fh, $file);
            fclose($fh);

            $className = ucfirst($name) . ".php";

            $output->writeln("Created $className in App\\Model");
        } else {
            $output->writeln("Class model already Exists!");
        }
    }

}

