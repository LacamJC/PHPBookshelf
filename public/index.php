<?php 
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once dirname(__DIR__, 1) . '/routes/routes.php';
require_once dirname(__DIR__, 1) . '/vendor/autoload.php';

echo "URL capturada: " . ($_GET['url'] ?? '/');

$router->dispatch();

