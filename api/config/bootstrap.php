<?php
header("Access-Control-Allow-Origin: https://www.whitecat.fr");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

session_set_cookie_params([
    'samesite' => 'None',
    'secure' => true,
    'httponly' => true,
    'path' => '/'
]);

session_start();

date_default_timezone_set('Europe/Paris');