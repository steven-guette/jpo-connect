<?php
require dirname(__DIR__) . '/config/bootstrap.php';
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/config/routes.php';

use Core\Http\Kernel;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$kernel = new Kernel();
$kernel->run();

