<?php

session_start();
$_SESSION['userRole']= 'guest';
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
