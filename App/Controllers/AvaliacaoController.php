<?php

namespace App\Controllers;

use App\Core\Response;
use App\Middlewares\AuthMiddleware;
use App\Services\AvaliacaoService;

class AvaliacaoController
{
    public function avaliar()
    {
        AuthMiddleware::handle();
        AuthMiddleware::token($_POST['edit_token']);
        unset($_POST['edit_token']);

        $dados = $_POST;

        foreach ($dados as $campo) {
            if ($campo == null) {
                Response::redirect('home', 'Desculpe houve um erro ao realizar o comentario', 'danger');
            }
        }

        AvaliacaoService::avaliar($dados);
    }

    public function apagarAvaliacao($params = [])
    {
        $id = $params['id'];
        if ($id == null) {
            Response::redirect('home', 'Desculpe, comentario não encontrado', 'danger');
        }

        AvaliacaoService::apagar($id);
    }
}
