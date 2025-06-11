<?php
require dirname(__DIR__) . '/config/bootstrap.php';
require dirname(__DIR__) . '/config/routes.php';

use Core\Http\Kernel;

$kernel = new Kernel();
$kernel->run();

