<?php 

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Api\Core\Router;

$router = new Router(); 

$router->get('/', 'HomeController@index');

$router->get('login', 'PageController@home');

$router->post('verify', 'UserController@login');

return $router;
