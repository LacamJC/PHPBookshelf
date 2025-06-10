<?php

namespace Api\Services;

use Api\Core\LoggerTXT;
use Api\Core\Response;
use Api\Database\AvaliacaoGateway;
use Api\Database\Connection;
use Exception;

class AvaliacaoService
{
    public static function avaliar($dados)
    {
        try {

            $conn = Connection::open('database');
            AvaliacaoGateway::setConnection($conn);

            $avaliacao = new AvaliacaoGateway;
            $avaliacao->id_livro = $dados['id_livro'];
            $avaliacao->id_usuario = $dados['id_usuario'];
            $avaliacao->comentario = $dados['comentario'];
            $avaliacao->nota = $dados['nota'];

            $result = $avaliacao->userHasComment();

            if (($result)) {
                return Response::redirect("livros/{$avaliacao->id_livro}", 'Você já comentou este livro', 'warning');
            }

            $avaliacao->save();
            return Response::redirect("livros/{$avaliacao->id_livro}", 'Avaliação salva com sucesso', 'success');
        } catch (Exception $e) {
            LoggerTXT::log('AvaliacaoService: ' . $e->getMessage(), 'Error');
            Response::redirect('home', 'Desculpe houve um erro ao realizar o comentario', 'danger');
        }
    }

    public static function comentarios($id)
    {
        try {
            $conn = Connection::open('database');
            AvaliacaoGateway::setConnection($conn);
            $comentarios = AvaliacaoGateway::comentarios($id);

            // echo "<pre>";
            // print_r($comentarios);
            // echo "</pre>";
            // die();
            if ($comentarios) {
                return $comentarios;
            } else {
                return null;
            }
        } catch (Exception $e) {
            LoggerTXT::log('AvaliacaoService@comentarios: ' . $e->getMessage(), 'Error');
            return response::redirect('livros/' . $id, 'Desculpe, houve um erro ao comentar o livro', 'danger');
        }
    }

    public static function editarComentario($id)
    {
        echo "Editando comentario do id: $id";
    }

    public static function apagar($id)
    {
        try {
            $conn = Connection::open('database');
            AvaliacaoGateway::setConnection($conn);
            
            $avaliacao = AvaliacaoGateway::findByIdLivro($id);
            $id_usuario_avaliacao = $avaliacao->id_usuario;
            $id_usuario = $_SESSION['user']->id;
            $livro = LivroService::findById($avaliacao->id_livro);
            if($id_usuario_avaliacao != $id_usuario){
                Response::redirect('home', 'Você não pode deletar o comentario de outro usuário');
            }

            $result = AvaliacaoGateway::delete($id);

            if($result){
                Response::redirect("livros/{$livro->id}", 'Comentario apagado com suceso', 'success');
            }else{
                throw new Exception('Houve um erro ao apagar o comentario');
            }
        } catch (Exception $e) {
            LoggerTXT::log('AvaliacaoService@apagar : ' . $e->getMessage(), 'Error');
            return response::redirect('home', 'Desculpe houve um erro ao apagar o comentario', 'danger');
        }
    }
}
