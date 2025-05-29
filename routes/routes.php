<?php 

require dirname(__DIR__, 1) . '/vendor/autoload.php';

use Api\Core\Router;

$router = new Router(); 

$router->get('/', 'PageController@login');
$router->get('home', 'PageController@home');

$router->get('logout', 'UserController@logout');

$router->get('login', 'PageController@login');
$router->get('cadastro', 'PageController@cadastro');

$router->post('verify', 'UserController@login');
$router->post('user', 'UserController@store');


return $router;
