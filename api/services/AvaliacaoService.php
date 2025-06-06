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
            
            $avaliacao->save();
        } catch (Exception $e) {
            LoggerTXT::log('AvaliacaoService: ' . $e->getMessage(), 'Error');
            Response::redirect('home', 'Desculpe houve um erro ao realizar o comentario', 'danger');
        }
    }
}
