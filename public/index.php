<?php
session_start();
require_once dirname(__DIR__, 1) . '/vendor/autoload.php';
require_once dirname(__DIR__, 1) . '/routes/routes.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

define('BASE_URL', '/My_Bookshelf_2025/public/');
error_reporting(E_ALL);
ini_set('display_errors', 1);




$router->dispatch();

    // echo "<div class='alert alert-primary mt-3 mx-auto w-50 text-center'>";
    // echo "URL capturada: " . ($_GET['url'] ?? '/');
    // echo "</div>";
