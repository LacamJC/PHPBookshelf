<?php

namespace Api\Services;

use Api\Core\Response;
use Api\Database\Connection;
use Api\Database\LivroGateway;
use Api\Middlewares\AuthMiddleware;
use Exception;


class LivroService
{

    public static function all()
    {
        try {
            $conn = Connection::open('database');
            LivroGateway::setConnection($conn);

            // $livros = LivroGateway::all();

            $total = LivroGateway::countAll(); // Corrigido aqui
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;



            $limit = 4;
            $offset = ($page - 1) * $limit;

            $livros = LivroGateway::paginate($limit, $offset);
            $totalPages = ceil($total / $limit);

            if ($page > $totalPages) {
                Response::redirect('livros?page=1', 'Indice de paginação não encontrado', 'warning');
            }

            return [
                'livros' => $livros,
                'total' => $total,
                'page' => $page,
                'totalPages' => $totalPages,
                'limit' => $limit,
                'offset' => $offset
            ];
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function show($titulo, $descricao, $autor, $editora, $imagem, $link)
    {
        echo "<div class='card' style='width: 18rem;'>";
        echo "    <img src='...' class='card-img-top' alt='...'>";
        echo "    <div class='card-body'>";
        echo "        <h5 class='card-title'>Card title</h5>";
        echo "        <p class='card-text'>Some quick example text to build on the card title and make up the bulk of the card’s content.</p>";
        echo "        <a href='#' class='btn btn-primary'>Go somewhere</a>";
        echo "    </div>";
        echo "</div>";
    }

    public static function store($dados)
    {
        try {
            $conn = Connection::open('database');
            LivroGateway::setConnection($conn);
            $livro = new LivroGateway;

            foreach ($dados as $chave => $valor) {
                $livro->$chave = $valor;
            }
            echo "<pre>";
            print_r($livro);
            echo "</pre>";
            $res = $livro->save();

            if ($res) {
                Response::redirect('book', 'Livro cadastrado com sucesso', 'success');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function paginated($limit, $offset)
    {
        try {
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
