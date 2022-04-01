<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Content-Length, Accept-Encoding, Accept, Authorization, X-Request-With, Access-Control-Request-Method');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') die();

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

/*
|---------------------------------------------------------------
| BOOTSTRAP THE APPLICATION
|---------------------------------------------------------------
| This process sets up the path constants, loads and registers
| our autoloader, along with Composer's, loads our constants
| and fires up an environment-specific bootstrapping.
*/
// Ensure the current directory is pointing to the front controller's directory
chdir(__DIR__);

// Load our paths config file
// This is the line that might need to be changed, depending on your folder structure.
// Change this if you move your application folder
$pathsConfig = FCPATH . '../app/Config/Paths.php';

require realpath($pathsConfig) ?: $pathsConfig;

$paths = new Config\Paths();

// Location of the framework bootstrap file.
$bootstrap = rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
$app = require realpath($bootstrap) ?: $bootstrap;

/*
|---------------------------------------------------------------
| LAUNCH THE APPLICATION
|---------------------------------------------------------------
| Now that everything is setup, it's time to actually fire
| up the engines and make this app do its thang.
*/
$app->run();
