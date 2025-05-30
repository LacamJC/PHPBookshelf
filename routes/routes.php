<?php 

require dirname(__DIR__, 1) . '/vendor/autoload.php';

use Api\Core\Router;

$router = new Router(); 

// Rotas de autenticação e usuário
$router->get('/', 'PageController@login');                   // Redirecionamento padrão
$router->get('login', 'PageController@login');               // Exibe tela de login
$router->post('login', 'UserController@login');              // Processa login
$router->get('logout', 'UserController@logout');             // Logout

$router->get('cadastro', 'PageController@cadastro');         // Tela de cadastro
$router->post('usuarios', 'UserController@store');           // Cadastra usuário

$router->get('home', 'PageController@home');            // Página inicial após login
$router->get('livros', 'PageController@lista');              // Lista de livros

$router->get('livros/cadastrar', 'PageController@cadastrarLivro'); // Formulário de cadastro
$router->post('livros', 'LivroController@store');            // Cria novo livro (POST)

// Exemplo para futuro (edição e exclusão):
$router->get('livros/editar/{id}', 'PageController@edit');
$router->post('livros/update', 'LivroController@update');
$router->get('livros/delete/{id}/{token}', 'LivroController@delete');
$router->get('livros/{id}', 'PageController@view');
// $router->post('livros/{id}', 'LivroController@update');
// $router->post('livros/{id}/excluir', 'LivroController@destroy');

return $router;
 