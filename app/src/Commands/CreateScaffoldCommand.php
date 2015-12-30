<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;



class CreateScaffoldCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('create:scaffold')
            ->setDescription('Create a Action and Model Class')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Name of the Class to Create'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name   = $input->getArgument('name');
        $model  = "app/src/Model/";
        $action = "app/src/Action/";
        $migration      = "migrations/";
        $file_model     = file_get_contents("resources/model_template.txt");
        $file_action    = file_get_contents("resources/action_template.txt");
        $file_migration = file_get_contents("resources/migration_template.txt");
        $file_model     = str_replace("!name", $name, $file_model);
        $file_model     = str_replace("?name", strtolower($name), $file_model);
        $file_migration = str_replace("!name", $name, $file_migration);
        $file_migration = str_replace("?name", strtolower($name), $file_migration);
        $file_action    = str_replace("!name", $name, $file_action);

        if (!file_exists($model.$name.".php")) {
            $fh = fopen($model . $name . ".php", "w");
            fwrite($fh, $file_model);
            fclose($fh);

            $classModel = $name . ".php";

            $output->writeln("Created $classModel in App\\Model");
            if (!file_exists($action.$name."Action.php")) {
                $fha = fopen($action . $name . "Action.php", "w");
                fwrite($fha, $file_action);
                fclose($fha);

                $classAction = $name . "Action.php";

                $output->writeln("Created $classAction in App\\Actions");
                if (!file_exists($migration.date('YmdHis')."_".$name.".php")) {
                    $fhm = fopen($migration.date('YmdHis') . "_". $name . ".php", "w");
                    if(fwrite($fhm, $file_migration)){
                        $classMig = date('YmdHis') ."_".$name . ".php";

                        $output->writeln("Created $classMig in migrations");
                    }else{
                        $output->writeln("Created $classMig failed");
                    }
                    fclose($fhm);
                } else {
                    $output->writeln("Class Migration already Exists!");
                }
            } else {
                $output->writeln("Class Action already Exists!");
            }
        } else {
            $output->writeln("Class Model already Exists!");
        }
        
    }

}

