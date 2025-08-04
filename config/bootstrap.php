<?php

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

define('BASE_URL', '/');
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
