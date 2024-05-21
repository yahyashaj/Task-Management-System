<?php

$DEBUG = 0;

if ($DEBUG) {
    ini_set("display_errors", "on");
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

define("DBHOST", "localhost");
define("DBNAME", "enagagesoftAssignment");
define("DBUSER", "root");
define("DBPASS", "");



define("ROOTPATH", dirname(__FILE__) . "/../");
define("PASS_KEY", "yahya2323");
define("JWT_SEC_KEY", '2323');

spl_autoload_register(function ($class_name) {
    include  __DIR__ . '/../lib/' . $class_name . '.php';
    
});


#---------------
