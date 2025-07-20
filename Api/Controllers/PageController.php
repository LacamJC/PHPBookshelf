<?php

namespace Api\Controllers;

use Api\Core\Response;
use Api\Middlewares\AuthMiddleware;
use Api\Services\AvaliacaoService;
use Api\Services\LivroService;
use Api\Services\UserService;


class PageController
{
    private LivroService $LivroService;

    public function __construct(?LivroService $LivroService = new LivroService)
    {
        $this->LivroService = $LivroService;
    }

    public function home()
    {
        AuthMiddleware::handle();
        include dirname(__DIR__) . '/Views/home.php';
    }

    public function lista()
    {
        AuthMiddleware::handle();
        include dirname(__DIR__) . '/Views/livros/lista.php';
    }

    public function cadastro()
    {
        include dirname(__DIR__) . '/Views/cadastro.php';
    }

    public function cadastrarLivro()
    {
        AuthMiddleware::handle();
        include dirname(__DIR__) . '/Views/livros/cadastro.php';
    }

    public function view(array $params = [])
    {
        AuthMiddleware::handle();
        $id = $params['id'] ?? null;

        $livro = $this->LivroService->findById($id);

        $comentarios = AvaliacaoService::buscarComentarios($id);



        include dirname(__DIR__) . '/Views/livros/visualizar.php';
    }

    public function editarAvaliacao($params = [])
    {
        $id = $params['id'];
        if ($id == null) {
            Response::redirect("livros/{$id}", 'Erro ao acessar comentario para edição', 'warning');
        }

        $result = AvaliacaoService::editarComentario($id);
    }

    public function edit($params = [])
    {
        AuthMiddleware::handle();
        $id = $params['id'] ?? null;

        // $livro = LivroService::findById($id);
        $livro = $this->LivroService->findById($id);

        include dirname(__DIR__) . '/Views/livros/editar.php';
    }

    public function login()
    {
        include dirname(__DIR__) . '/Views/login.php';
    }

    public function editUser($params = [])
    {
        $id = $params['id'];
        $token = $params['token'];
        AuthMiddleware::handle();
        AuthMiddleware::token($token);

        $user = UserService::findById($id);

        $_SESSION['form_data'] = $user;

        include dirname(__DIR__) . '/Views/usuarios/editar.php';
    }
}
