<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;


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
            ->addArgument(
                'column',
                InputArgument::IS_ARRAY,
                'column name (column:type)'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Generate Migration
        //====================================================
        $migration = $this->getApplication()->find('create:migration');
        $migration_arguments = array(
                'command' => 'create:migration',
                'name'      => $input->getArgument('name'),
                'column'    => $input->getArgument('column')
        );

        $input_migration = new ArrayInput($migration_arguments);
        $returnmigration = $migration->run($input_migration, $output);
        $output->writeln($returnmigration);

        // Generate Action
        //====================================================
        $action = $this->getApplication()->find('create:action');
        $arguments = array(
                'command' => 'create:action',
                'name'      => $input->getArgument('name'),
        );

        $input = new ArrayInput($arguments);
        $returnCode = $action->run($input, $output);
        $output->writeln($returnCode);

        // Generate Model
        //=====================================================
        $model = $this->getApplication()->find('create:model');
        $model_arguments = array(
                'command' => 'create:model',
                'name'      => $input->getArgument('name'),
        );
        $input_model = new ArrayInput($model_arguments);
        $returnmodel = $model->run($input_model, $output);
        $output->writeln($returnmodel);        
    }

}

