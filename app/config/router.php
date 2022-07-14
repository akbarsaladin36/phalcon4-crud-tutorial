<?php

$router = $di->getRouter();

// Define your routes here

// Auth
// $router->addPost('/:controller/:action',['controller' => 'Auth','action' => 'register']);
$router->addPost('/Auth/register','Auth::register');
$router->addPost('/Auth/login','Auth::login');
$router->addPost('/logout', 'Auth::logout');
// $router->addPost('/:controller/:action',['controller' => 'Auth','action' => 'login']);

// Users
// $router->addGet('/:controller/:action',['controller' => 'User','action' => 'index']);
$router->addGet('/User/index', 'User::index');
$router->addGet('/User/show/{id}', 'User::show');
$router->addGet('/User/testingSession', 'User::testingSession');
// $router->addGet('/:controller/:action/:parameter1',['controller' => 'User','action' => 'show','parameter1'=>':id']);
// $router->addGet('/:controller/:action',['controller' => 'User','action' => 'testingSession']);
// $router->addGet('/:controller/:action',['controller' => 'User','action' => 'testingLogout']);