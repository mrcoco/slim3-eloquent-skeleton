<?php
// application.php

require 'vendor/autoload.php';

use App\Commands\CreateActionCommand;
use App\Commands\CreateMiddlewareCommand;
use App\Commands\CreateModelCommand;
use App\Commands\CreateScaffoldCommand;
use App\Commands\MigrationGeneratorCommand;
use Phpmig\Console\Command;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new CreateActionCommand());
$application->add(new CreateMiddlewareCommand());
$application->add(new CreateModelCommand());
$application->add(new CreateScaffoldCommand());
$application->add(new MigrationGeneratorCommand());
$application->addCommands(array(
            new Command\InitCommand(),
            new Command\StatusCommand(),
            new Command\CheckCommand(),
            new Command\GenerateCommand(),
            new Command\UpCommand(),
            new Command\DownCommand(),
            new Command\MigrateCommand(),
            new Command\RollbackCommand(),
            new Command\RedoCommand()
        ));
$application->run();