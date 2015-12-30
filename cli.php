<?php
// application.php

require 'vendor/autoload.php';

use App\Commands\CreateActionCommand;
use App\Commands\CreateMiddlewareCommand;
use App\Commands\CreateModelCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new CreateActionCommand());
$application->add(new CreateMiddlewareCommand());
$application->add(new CreateModelCommand());
$application->run();