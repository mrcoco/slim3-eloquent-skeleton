<?php
// Routes

$app->get('/', 'App\Action\HomeAction:dispatch')->setName('homepage');
$app->get('/login', 'App\Action\HomeAction:login')->setName('login');
$app->get('/logout', 'App\Action\HomeAction:logout')->setName('logout');
$app->get('/admin','App\Action\Admin:index')->setName('logout');
$app->get('/register', 'App\Action\HomeAction:register')->setName('register');
$app->get('/dashboard', 'App\Action\HomeAction:dashboard')->setName('dashboard');
$app->post('/login','App\Action\HomeAction:loginPost')->setName('login.post');
$app->post('/register','App\Action\HomeAction:registerPost')->setName('register.post');