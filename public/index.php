<?php

require_once dirname(__DIR__, 1) . '/vendor/autoload.php';
require_once dirname(__DIR__, 1) . '/routes/routes.php';
require_once dirname(__DIR__, 1) . '/config/bootstrap.php';

$router->dispatch();