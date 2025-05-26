<?php 

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Api\Core\Router;

$router = new Router(); 

$router->get('/', 'HomeController@index');

return $router;
