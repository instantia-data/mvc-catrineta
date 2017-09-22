<?php
error_reporting(E_ALL);
ini_set('display_errors', "1");

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('HTMROOT', getcwd());
define('BOOT_DIR', ROOT . DS . 'boot' . DS);
 
require_once (BOOT_DIR . 'boot.php');
