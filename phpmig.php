<?php
date_default_timezone_set("Asia/Jakarta");
require_once 'vendor/autoload.php';
use Phpmig\Adapter;
use Illuminate\Database\Capsule\Manager as Capsule;
$config    = require_once 'app/settings.php';
$capsule   = new Capsule;
$capsule->addConnection($config['settings']['database']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
$container = new ArrayObject();
$container['phpmig.adapter'] = new Adapter\Illuminate\Database($capsule, 'migrations');
$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';
$container['phpmig.migrations_template_path'] = $container['phpmig.migrations_path'] . DIRECTORY_SEPARATOR . '.template.php';
return $container;