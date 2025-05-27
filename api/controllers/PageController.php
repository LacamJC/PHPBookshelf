<?php 

namespace Api\Controllers;

class PageController{
    public function home(){
        include dirname(__DIR__) . '/views/home.php';
    }

    public function cadastro(){
        include dirname(__DIR__) . '/views/cadastro.php';
    }

    public function login(){
        include dirname(__DIR__) . '/views/login.php';
    }

}