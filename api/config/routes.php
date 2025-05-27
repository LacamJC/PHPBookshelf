<?php 

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Api\Core\Router;

$router = new Router(); 

$router->get('home', 'PageController@home');

$router->get('login', 'PageController@home');
$router->get('cadastro', 'PageController@cadastro');

$router->post('verify', 'UserController@login');
$router->post('user', 'UserController@store');


return $router;
