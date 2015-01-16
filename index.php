<?php
//if (file_exists('gfun.php')) {
//    include_once 'gfun.php';
//}//help function

define('ROOT_PATH', dirname(__FILE__));
define('APP_ENV', getenv('APP_ENV'));

require 'vendor/autoload.php';

new FrontController();