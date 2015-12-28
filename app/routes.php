<?php
// Routes
use App\Model\Route;
$app->get('/','App\Action\HomeAction:dispatch')->setName('homepage');
$app->get('/login', 'App\Action\HomeAction:login')->setName('login');
$app->get('/logout', 'App\Action\HomeAction:logout')->setName('logout');
$app->get('/register', 'App\Action\HomeAction:register')->setName('register');
$app->get('/dashboard', 'App\Action\HomeAction:dashboard')->setName('dashboard');
$app->post('/login','App\Action\HomeAction:loginPost')->setName('login.post');
$app->post('/register','App\Action\HomeAction:registerPost')->setName('register.post');
$route = Route::all();
foreach ($route as $rt) {
	$app->get('/'.$rt->route,$rt->address)->setName($rt->route);
}