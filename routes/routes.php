<?php 

require dirname(__DIR__, 1) . '/vendor/autoload.php';

use Api\Core\Router;

$router = new Router(); 

// Rotas de autenticação e usuário
$router->get('/', 'PageController@login');                   // Redirecionamento padrão
$router->get('login', 'PageController@login');               // Exibe tela de login
$router->get('logout', 'UserController@logout');             // Logout

$router->post('login', 'UserController@login');              // Processa login

$router->get('usuarios/apagar-conta/{id}/{token}', 'UserController@delete');
$router->post('usuarios', 'UserController@store');           // Cadastra usuário
$router->get('cadastro', 'PageController@cadastro');         // Tela de cadastro
$router->get('home', 'PageController@home');            // Página inicial após login


$router->get('livros', 'PageController@lista');              // Lista de livros
$router->get('livros/cadastrar', 'PageController@cadastrarLivro'); // Formulário de cadastro
$router->get('livros/editar/{id}', 'PageController@edit');
$router->get('livros/{id}', 'PageController@view');
$router->get('livros/delete/{id}/{token}', 'LivroController@delete');

$router->post('livros', 'LivroController@store'); 
$router->post('livros/update', 'LivroController@update');

return $router;
 