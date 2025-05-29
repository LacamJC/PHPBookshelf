<?php 

namespace Api\Middlewares;
use Api\Core\Response;

class AuthMiddleware{
    public static function handle(){
        if(empty($_SESSION['user'])){
            Response::redirect('login', 'errorMessage', 'Você realizou logout');
            exit;
        }
    }
}