<?php

namespace App\Controllers;

use App\Core\Response;
use App\Middlewares\AuthMiddleware;
use App\Services\AuthService;
use App\Services\AvaliacaoService;
use App\Services\LivroService;
use App\Services\UserService;


class PageController
{
    private LivroService $LivroService;
    private UserService $UserService;
    private AuthService $AuthService;

    public function __construct(?LivroService $LivroService = new LivroService, ?UserService $UserService = new UserService, ?AuthService $AuthService = new AuthService)
    {
        $this->LivroService = $LivroService;
        $this->UserService = $UserService;
        $this->AuthService = $AuthService;
    }

    public function home(): Void
    {
        AuthMiddleware::handle();
        include dirname(__DIR__) . '/Views/home.php';
    }

    public function lista(): Void
    {
        AuthMiddleware::handle();
        include dirname(__DIR__) . '/Views/livros/lista.php';
    }

    public function cadastro(): Void
    {
        include dirname(__DIR__) . '/Views/cadastro.php';
    }

    public function cadastrarLivro(): Void
    {
        AuthMiddleware::handle();
        include dirname(__DIR__) . '/Views/livros/cadastro.php';
    }

    public function view(array $params = []): Void
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
        // não desenvolvido
    }

    public function edit($params = []): Void
    {
        AuthMiddleware::handle();
        $id = $params['id'] ?? null;

        // $livro = LivroService::findById($id);
        $livro = $this->LivroService->findById($id);

        include dirname(__DIR__) . '/Views/livros/editar.php';
    }

    public function login(): Void
    {
        include dirname(__DIR__) . '/Views/login.php';
    }

    public function editUser($params = []): Void
    {
        $id = $params['id'];
        $token = $params['token'];
        AuthMiddleware::handle();
        AuthMiddleware::token($token);

        $user = $this->UserService->findById($id);

        $this->AuthService->setForm($user);

        include dirname(__DIR__) . '/Views/usuarios/editar.php';
    }
}
