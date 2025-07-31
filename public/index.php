<?php


require_once dirname(__DIR__, 1) . '/vendor/autoload.php';
require_once dirname(__DIR__, 1) . '/routes/routes.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

define('BASE_URL', '/');
error_reporting(E_ALL);
ini_set('display_errors', 1);


// echo "<div class='alert alert-primary mt-3 mx-auto w-50 text-center'>";
// echo "URL capturada: " . ($_GET['url'] ?? '/');
// echo "</div>";


$router->dispatch();
