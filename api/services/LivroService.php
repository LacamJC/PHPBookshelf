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
            $genero = isset($_GET['genero']) ? $_GET['genero'] : '';



            $limit = 4;
            $offset = ($page - 1) * $limit;

            $livros = LivroGateway::paginate($limit, $offset);
            $totalPages = ceil($total / $limit);

            if ($page > $totalPages or $page < 1) {
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

            return $res;
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

    public static function findById($id)
    {
        try {
            $conn = Connection::open('database');
            LivroGateway::setConnection($conn);

            $livro = LivroGateway::findById($id);
            if (!isset($livro->id)) {
                echo "Livro não encontrado <br>";
                Response::redirect('home', 'Desculpe, não encontramos o livro que está procurando', 'warning');
            }

            return $livro;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function delete($id)
    {
        try {
            $conn = Connection::open('database');
            LivroGateway::setConnection($conn);
            $livro = self::findById($id);
            $capa_path = $livro->capa_path;
            if (LivroGateway::delete($id)) {
                if(file_exists($capa_path) and strcmp($capa_path, 'uploads/placeholder.png')){
                    if(unlink($capa_path)){
                        echo "Arquivo deletado com sucesso";
                    }else{
                        echo "Erro ao deletar arquivo";
                    }
                }else{
                    echo "Erro ao deletar arquivo";
                }

                Response::redirect('livros', 'Sucesso ao deletar livro', 'success');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
