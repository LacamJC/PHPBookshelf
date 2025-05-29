<?php

namespace Api\Services;

use Api\Core\Response;
use Api\Database\Connection;
use Api\Database\LivroGateway;
use Api\Middlewares\AuthMiddleware;
use Exception;


class LivroService
{

    public static function store($dados)
    {
        try {
            $conn = Connection::open('database');
            LivroGateway::setConnection($conn);
            $livro = new LivroGateway;

            foreach($dados as $chave => $valor){
                $livro->$chave = $valor;
            }
            echo "<pre>";
            print_r($livro);
            echo "</pre>";
            $res = $livro->save();

            if($res){
                Response::redirect('book', 'Livro cadastrado com sucesso', 'success');
            }


        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
