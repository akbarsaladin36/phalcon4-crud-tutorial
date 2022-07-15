<?php

$router = $di->getRouter();

// Define your routes here

// Auth
$router->addPost('/Auth/register','Auth::register');
$router->addPost('/Auth/login','Auth::login');
$router->addPost('/logout','Auth::logout');

// Users
$router->addGet('/User/index','User::index');
$router->addPost('/User/store','User::store');
$router->addGet('/User/show/{id}','User::show');
$router->addPatch('/User/update/{id}','User::update');
$router->addDelete('/User/delete/{id}', 'User::delete');

//Session
$router->addGet('/User/testingSession', 'User::testingSession');