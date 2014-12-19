<?php

session_start();
include_once ROOT_PATH . '/framework/classes/Config.php';
include_once ROOT_PATH . '/framework/classes/Registry.php';
include_once ROOT_PATH . '/framework/classes/Database.php';
include_once ROOT_PATH . '/framework/classes/Auth.php';
include_once ROOT_PATH . '/framework/classes/Acl.php';
include_once ROOT_PATH . '/framework/core/Model.php';
include_once ROOT_PATH . '/framework/core/View.php';
include_once ROOT_PATH . '/framework/core/Controller.php';
include_once ROOT_PATH . '/framework/core/Dispatcher.php';
Config::init('dev');
Dispatcher::start();
var_dump($_SERVER['HTTP_HOST'] . '/');
var_dump($_SESSION);
var_dump(Config::get('users'));