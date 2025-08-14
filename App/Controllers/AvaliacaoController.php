<?php

namespace App\Controllers;

use App\Core\Response;
use App\Database\AvaliacaoGateway;
use App\Database\Connection;
use App\Database\UserGateway;
use App\Helpers\Dtos\AvaliacaoDTO;
use App\Middlewares\AuthMiddleware;
use App\Models\ValueObjects\Avaliacao;
use App\Services\AvaliacaoService;
use App\Services\UserService;

class AvaliacaoController
{
    private AvaliacaoService $avaliacaoService;

    public function __construct(?AvaliacaoService $avaliacaoService = null){
        if(is_null($avaliacaoService)){
        //     $conn = Connection::open($_ENV['CONNECTION_NAME']);
        //     $userService = new UserService(new UserGateway($conn));
        //     $avaliacaoService = new AvaliacaoService(new AvaliacaoGateway($conn), $userService);
        }

        $this->avaliacaoService = $avaliacaoService;
    }

    public function avaliar()
    {
        AuthMiddleware::handle();
        AuthMiddleware::token($_POST['edit_token']);
        unset($_POST['edit_token']);

        $comment = AvaliacaoDTO::fromArray($_POST)->toModel();


        $this->avaliacaoService->avaliar($comment);

        return Response::redirect('livros/' . $comment->id_livro);
    }

    public function apagarAvaliacao($params = []): Response
    {
        $id = $params['id'];
        $id_livro = $params['idlivro'];
        if ($id == null) {
            Response::redirect('home', 'Desculpe, comentario não encontrado', 'danger');
        }

        $this->avaliacaoService->apagar($id);

        return Response::redirect('livros/' . $id_livro, 'Comentario apagado com sucesso', 'success');
    }
}
