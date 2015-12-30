<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;



class MigrationGeneratorCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('generate:migration')
            ->setDescription('Generate Model Class')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Model name to Generate'
            )
            ->addArgument(
                'column',
                InputArgument::IS_ARRAY,
                'column name (column:type) '
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $names   = $input->getArgument('name');
        $column = $input->getArgument('column');
        $dialog = $this->getHelperSet()->get('dialog');
        //$output->writeln('The "%s" directory is not writable');
        //    if (!$dialog->askConfirmation($output, '<question>check your Type data first (bigIncremens|bigInteger|binary|boolean|char|date|dateTime|decimal|double|enum|float|increment|integer|smallInteger|string|text ) </question>')) {
        //        return;
        //    }

        $map ="";
        $directory = 'migrations/';
        $file = file_get_contents("resources/migration2_template.txt");

        $file = str_replace("!name", $names, $file);
        $file = str_replace("?name", strtolower($names), $file);
        foreach ($column as $c) {
            $entity = explode(":", $c);
            $name   = $entity[0];
            $type   = $entity[1];
            //$map    .= "$table->".$type."('".$name."');".'\r\n';
            $map    .= '$table->'.$type.'("'.$name.'");'."\n";
        }
        $file = str_replace("!table", $map, $file);
        if (!file_exists($directory.date('YmdHis')."_".$names.".php")) {
            $fh = fopen($directory .date('YmdHis')."_". $names . ".php", "w");
            fwrite($fh, $file);
            fclose($fh);

            $className = $names . ".php";

            $output->writeln("Created $className in migrations");
        } else {
            $output->writeln("Class already Exists!");
        }
        
    }

}

