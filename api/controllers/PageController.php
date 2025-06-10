<?php

namespace Api\Controllers;

use Api\Core\Response;
use Api\Middlewares\AuthMiddleware;
use Api\Services\AvaliacaoService;
use Api\Services\LivroService;
use Api\Services\UserService;

class PageController
{
    public function home()
    {
        AuthMiddleware::handle();
        include dirname(__DIR__) . '/views/home.php';
    }

    public function lista()
    {
        AuthMiddleware::handle();
        include dirname(__DIR__) . '/views/livros/lista.php';
    }

    public function cadastro()
    {
        include dirname(__DIR__) . '/views/cadastro.php';
    }

    public function cadastrarLivro()
    {
        AuthMiddleware::handle();
        include dirname(__DIR__) . '/views/livros/cadastro.php';
    }

    public function view($params = [])
    {
        AuthMiddleware::handle();
        $id = $params['id'] ?? null;

        $livro = LivroService::findById($id);
        $comentarios = AvaliacaoService::buscarComentarios($id);



        include dirname(__DIR__) . '/views/livros/visualizar.php';
    }

    public function editarAvaliacao($params = []){
        $id = $params['id'];
        if($id == null){
            Response::redirect("livros/{$id}", 'Erro ao acessar comentario para edição', 'warning');
        }

        $result = AvaliacaoService::editarComentario($id);
    }

    public function edit($params = [])
    {
        AuthMiddleware::handle();
        $id = $params['id'] ?? null;

        $livro = LivroService::findById($id);

        include dirname(__DIR__) . '/views/livros/editar.php';
    }

    public function login()
    {
        include dirname(__DIR__) . '/views/login.php';
    }

    public function editUser($params = [])
    {
        $id = $params['id'];
        $token = $params['token'];
        AuthMiddleware::handle();
        AuthMiddleware::token($token);

        $user = UserService::findById($id);
        
        $_SESSION['form_data'] = $user;

        include dirname(__DIR__) . '/views/usuarios/editar.php';
    }
}
