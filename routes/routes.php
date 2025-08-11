<?php

use Api\Core\Router;

$router = new Router();

// Rotas de autenticação e acesso
$router->get('/', 'PageController@login');
$router->get('login', 'PageController@login');
$router->post('login', 'UserController@login');
$router->get('logout', 'UserController@logout');

// Rotas de usuário
$router->get('usuarios/apagar-conta/{id}/{token}', 'UserController@delete');
$router->get('usuarios/editar-conta/{id}/{token}', 'PageController@editUser');
$router->post('usuarios/editSubmit/{id}/{token}', 'UserController@edit');
$router->post('usuarios', 'UserController@store');
$router->get('cadastro', 'PageController@cadastro');
$router->get('home', 'PageController@home');

// Rotas de livros
$router->get('livros', 'PageController@lista');
$router->get('livros/cadastrar', 'PageController@cadastrarLivro');
$router->get('livros/editar/{id}', 'PageController@edit');
$router->post('livros/update', 'LivroController@update');
$router->get('livros/{id}', 'PageController@view');
$router->get('livros/delete/{id}/{token}', 'LivroController@delete');
$router->post('livros', 'LivroController@store');

// Rota de avaliações

$router->post('avaliar', 'AvaliacaoController@avaliar');
$router->get('avaliacao/editar/{id}', 'PageController@editarAvaliacao');
$router->get('avaliacao/apagar/{id}', 'AvaliacaoController@apagarAvaliacao');


$router->get('log', 'LogController@index');

return $router;
