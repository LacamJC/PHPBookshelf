<?php 

namespace Api\Controllers;

use Api\Middlewares\AuthMiddleware;
use Api\Services\LivroService;

class PageController{
    public function home(){
        AuthMiddleware::handle();
        include dirname(__DIR__) . '/views/home.php';
    }

    public function lista(){
        AuthMiddleware::handle();
        include dirname(__DIR__) . '/views/livros/lista.php';
    }

    public function cadastro(){
        include dirname(__DIR__) . '/views/cadastro.php';
    }

    public function cadastrarLivro(){
        AuthMiddleware::handle();
        include dirname(__DIR__) . '/views/livros/cadastro.php';
    }

    public function view($params = []) {
        AuthMiddleware::handle();
        $id = $params['id'] ?? null;

        $livro = LivroService::findById($id);
        
        include dirname(__DIR__) . '/views/livros/visualizar.php';
    }

    public function edit($params = []){
        AuthMiddleware::handle();
        $id = $params['id'] ?? null;

        $livro = LivroService::findById($id);

        include dirname(__DIR__) . '/views/livros/editar.php';
    }

    public function login(){
        include dirname(__DIR__) . '/views/login.php';
    }

}