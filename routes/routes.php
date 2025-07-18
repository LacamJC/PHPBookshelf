<?php

require dirname(__DIR__, 1) . '/vendor/autoload.php';

use Api\Core\Router;


$router = new Router();

// Rotas de autenticação e acesso
$router->get('/', 'PageController@login');                   // Redirecionamento padrão para login
$router->get('login', 'PageController@login');               // Exibe tela de login
$router->post('login', 'UserController@login');              // Processa login
$router->get('logout', 'UserController@logout');             // Logout

// Rotas de usuário
$router->get('usuarios/apagar-conta/{id}/{token}', 'UserController@delete');
$router->get('usuarios/editar-conta/{id}/{token}', 'PageController@editUser');
$router->post('usuarios/editSubmit/{id}/{token}', 'UserController@edit');
$router->post('usuarios', 'UserController@store');           // Cadastra usuário
$router->get('cadastro', 'PageController@cadastro');         // Tela de cadastro
$router->get('home', 'PageController@home');                  // Página inicial após login

// Rotas de livros
$router->get('livros', 'PageController@lista');              // Lista de livros
$router->get('livros/cadastrar', 'PageController@cadastrarLivro'); // Formulário de cadastro
$router->get('livros/editar/{id}', 'PageController@edit');    // Editar livro (formulário)
$router->post('livros/update', 'LivroController@update');     // Atualizar livro (envio do form)
$router->get('livros/{id}', 'PageController@view');           // Visualizar detalhes do livro
$router->get('livros/delete/{id}/{token}', 'LivroController@delete'); // Deletar livro
$router->post('livros', 'LivroController@store');             // Cadastrar novo livro

// Rota de avaliações

$router->post('avaliar', 'AvaliacaoController@avaliar');
$router->get('avaliacao/editar/{id}', 'PageController@editarAvaliacao');
$router->get('avaliacao/apagar/{id}', 'AvaliacaoController@apagarAvaliacao');


$router->get('log', 'LogController@index');

return $router;
