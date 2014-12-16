<?php

include_once ROOT_PATH . '/framework/classes/Config.php';
include_once ROOT_PATH . '/framework/classes/Registry.php';
include_once ROOT_PATH . '/framework/classes/Database.php';
include_once ROOT_PATH . '/framework/core/Model.php';
include_once ROOT_PATH . '/framework/core/View.php';
include_once ROOT_PATH . '/framework/core/Controller.php';
include_once ROOT_PATH . '/framework/core/Dispatcher.php';
Config::init('dev');
Dispatcher::start();
$db= new Database();
v(Registry::get('action'));
v(Registry::get('controller'));
v(Registry::get('model'));
p($_SERVER);