<?php

namespace App\Middlewares;

use App\Core\Response;

class AuthMiddleware
{
    public static function handle()
    {
        if (empty($_SESSION['user'])) {
            Response::redirect('login', 'Você não possui as permissões para acessar este conteudo', 'warning');
            exit;
        }
    }

    public static function token($token)
    {
        if (strcmp($token, $_ENV['EDIT_TOKEN']) !== 0) {
            Response::redirect('home', 'Você não possui as permissões para realizar está operação', 'warning');
        }
    }
}
