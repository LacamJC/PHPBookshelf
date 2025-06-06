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

            if($comentarios){
                return $comentarios;
            }else{
                return null;
            }
        } catch (Exception $e) {
            LoggerTXT::log('AvaliacaoService@comentarios: ' . $e->getMessage(), 'Error');
            return response::redirect('livros/' . $id, 'Desculpe, houve um erro ao comentar o livro', 'danger');
        }
    }
}
