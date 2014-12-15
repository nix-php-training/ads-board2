<?php

define('ROOT', $_SERVER['DOCUMENT_ROOT']);

define('CTRL', ROOT . '/application/controllers/');
define('MDL', ROOT . '/application/models/');
define('VWS', ROOT . '/application/views/');
define('DLOUT', ROOT . '/application/views/layout/Layout.php');
define('ADB', ROOT . '/application/database/');


include 'framework/core/FrontController.php';

// load config
Config::init('dev');

// run application
FrontController::run();