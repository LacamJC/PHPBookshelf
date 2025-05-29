<?php 

namespace Api\Controllers;

use Api\Middlewares\AuthMiddleware;

class PageController{
    public function home(){
        AuthMiddleware::handle();
        include dirname(__DIR__) . '/views/home.php';
    }

    public function cadastro(){
        include dirname(__DIR__) . '/views/cadastro.php';
    }

    public function cadastrarLivro(){
        AuthMiddleware::handle();
        include dirname(__DIR__) . '/views/livros/cadastro.php';
    }

    public function login(){
        include dirname(__DIR__) . '/views/login.php';
    }

}