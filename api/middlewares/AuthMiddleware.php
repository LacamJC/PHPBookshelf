<?php 

namespace Api\Middlewares;
use Api\Core\Response;

class AuthMiddleware{
    public static function handle(){
        if(empty($_SESSION['user'])){
            Response::redirect('login', 'Você não possui as permissões para acessar este conteudo', 'warning');
            exit;
        }
    }
}