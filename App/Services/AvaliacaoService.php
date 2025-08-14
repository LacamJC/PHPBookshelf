<?php

namespace App\Services;

use App\Core\LoggerTXT;
use App\Core\Response;
use App\Database\AvaliacaoGateway;
use App\Database\Connection;
use App\Database\LivroGateway;
use App\Database\UserGateway;
use App\Helpers\Dtos\AvaliacaoDTO;
use App\Models\Avaliacao;
use Exception;
use InvalidArgumentException;

class AvaliacaoService
{
    private AvaliacaoGateway $avaliacaoGateway;

    public function __construct(?AvaliacaoGateway $avaliacaoGateway = null)
    {
        if(is_null($avaliacaoGateway)){
            $conn = Connection::open($_ENV['CONNECTION_NAME']);
            $avaliacaoGateway = new AvaliacaoGateway($conn);
        }
        $this->avaliacaoGateway = $avaliacaoGateway;
        
    }


    public function avaliar(Avaliacao $avaliacao): bool
    {
        return $this->avaliacaoGateway->save($avaliacao);
    }

    public function buscarComentarios($id)
    {
        try {
            $comentarios = $this->avaliacaoGateway->comentarios($id);

            if(!$comentarios){
                return null;
            }

            return $comentarios;
        } catch (Exception $e) {
            LoggerTXT::log('AvaliacaoService@comentarios: ' . $e->getMessage(), 'Error');
            return response::redirect('livros/' . $id, 'Desculpe, houve um erro ao comentar o livro', 'danger');
        }
    }

    public static function editarComentario($id)
    {
        echo "Editando comentario do id: $id";
    }

    public function apagar($id): void
    {
        try {
            // buscar comentario
            $comentario = $this->avaliacaoGateway->findById($id);
            if(!$comentario){
                throw new InvalidArgumentException('Comentário nao encontrado');
            }
            $comentarioModel = AvaliacaoDTO::fromObj($comentario)->toModel();
            $user = $this->userService->findById($comentarioModel->id_usuario);
            $valid = $comentarioModel->id_usuario === $user->id;
            if(!$valid){
                throw new InvalidArgumentException('Você não pode apagar este comentário');
            }

             $this->avaliacaoGateway->delete($comentarioModel->id);

        } catch (Exception $e) {
            LoggerTXT::log('AvaliacaoService@apagar : ' . $e->getMessage(), 'Error');
            throw $e;
        }
    }
}
