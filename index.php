<?php

define('ROOT', $_SERVER['DOCUMENT_ROOT']);

define('CLS', ROOT . '/framework/classes/');
define('DB', ROOT . '/framework/database/');

define('CTRL', ROOT . '/application/controllers/');
define('MDL', ROOT . '/application/models/');
define('VWS', ROOT . '/application/views/');
define('DLOUT', ROOT . '/application/views/layout/Layout.php');
define('ADB', ROOT . '/application/database/');

include 'framework/core/FrontController.php';

FrontController::run();