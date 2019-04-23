<?php
/**
 * Some of the application constants. Others have to be 
 * defined for the application, e.g. the plugins directory
 * and any other constants that will make it easier to 
 * build the application including the database username and password
 */
// create a constant to store the application root directory


define('APP_ROOT_DIR', '/Applications/MAMP/htdocs/assignment2/assigncode'); // add the application root directory, e.g. /home/comp3170-100/assignment3

define('URL_ROOT_DIR', 'http://localhost:8888/assignment2');

// location of the framework directory 
define('FRAMEWORK_DIR', APP_ROOT_DIR . '/framework');
define('APP_PAGES', APP_ROOT_DIR . '/pages');
define('APP_MODELS', APP_ROOT_DIR . '/models');
define('APP_TEMPLATES', APP_ROOT_DIR . '/templates');
define('APP_CLASSES', APP_ROOT_DIR . '/codebase');
define('INCLUDE_DIR', APP_ROOT_DIR . '/include');

define ('DB_USERNAME', 'root'); // enter your database username
define ('DB_PASS', 'root'); // enter your database password
define ('DB_HOST', 'localhost'); // enter your database host
define ('DB_SELECT', 'mooc'); // enter your database name






