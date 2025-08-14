<?php

namespace App\Services;


use App\Core\LoggerTXT;
use App\Database\Connection;
use App\Database\LivroGateway;
use App\Models\Livro;
use Exception;
use InvalidArgumentException;

class LivroService
{
    private LivroGateway $gateway;
    public function __construct(?LivroGateway $gateway = null)
    {
        if ($gateway === null) {
            $conn = Connection::open($_ENV['CONNECTION_NAME']);
            $gateway = new LivroGateway($conn);
        }
        $this->gateway = $gateway;
    }

    public function all(int $page = 1): array
    {
        try {

            if ($page < 1) {
                throw new InvalidArgumentException('Página de busca inválida: ' . $page);
            }
            $total = $this->gateway->countAll();

            $limit = 4;
            $offset = ($page - 1) * $limit;

            $totalPages = max(1, ceil($total / $limit));


            if ($page > $totalPages) {
                throw new InvalidArgumentException('Página de busca inválida: ' . $page);
            }
            $livros = $this->gateway->paginate($limit, $offset);


            return [
                'livros' => $livros,
                'total' => $total,
                'page' => $page,
                'totalPages' => $totalPages,
                'limit' => $limit,
                'offset' => $offset
            ];
        } catch (Exception $e) {
            LoggerTXT::log('LivroService@all: ' . $e->getMessage(), 'Error');
            throw $e;
        }
    }

    public function store(array $dados): bool
    {
        try {
            $livro = new Livro;
            foreach ($dados as $chave => $valor) {
                if (!in_array($chave, ['id', 'description']) && !isset($valor)) {
                    return false;
                }
                $livro->$chave = $valor;
            };


            $autoresPlain = explode(";", $livro->autores);
            $autoresFormatados = array_map(function ($autor) {
                return htmlspecialchars(trim($autor));
            }, $autoresPlain);


            $autores = '';
            $maxAutores = count($autoresFormatados);

            if ($maxAutores === 1) {
                $autores = $autoresFormatados[0];
            } else {
                for ($i = 0; $i < $maxAutores; $i++) {
                    if ($i === $maxAutores - 1) {
                        $autores .= " {$autoresFormatados[$i]}.";
                    } else {
                        $autores .= " {$autoresFormatados[$i]},";
                    }
                }
            }
            $livro->autores = $autores;

         

            $result = $this->gateway->save($livro);

            if ($result) {
                LoggerTXT::log("LivroService@store: Livro '{$livro->titulo}' cadastrado com sucesso", "Success");
            }
            return $result;
        } catch (Exception $e) {
            LoggerTXT::log("LivroService@store: {$e->getMessage()}", 'Error');
            throw $e;
        }
    }

    public function findById(int $id): Livro
    {
        try {
            $livro = $this->gateway->findById($id);
            if (!isset($livro)) {
                throw new Exception('Nenhum livro com o id ' . $id . ' foi encontrado.');
            }
            return $livro;
        } catch (Exception $e) {
            LoggerTXT::log('LivroService@findById: ' . $e->getMessage(), 'Error');
            throw $e;
            throw $e;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $livro = $this->gateway->findById($id);
            if (!$livro) {
                throw new Exception('Livro com o id ' . $id . ' não encontrado.');
            }
            $capa_path = $livro->capa_path;
            $result = $this->gateway->delete($id);
            if ($result) {
                if (file_exists($capa_path) and strcmp($capa_path, 'uploads/placeholder.png')) {
                    if (unlink($capa_path)) {
                        LoggerTXT::log('LivroService@delete: Apagando arquivo da capa do livro', 'Success');
                    } else {
                        LoggerTXT::log('LivroService@delete: Erro ao apagar capa do livro', 'Error');;
                    }
                }

                LoggerTXT::log('LivroService@delete: Registro do livro apagado com sucesso', 'Success');
            }
            return $result;
        } catch (Exception $e) {
            LoggerTXT::log("LivroService@delete: {$e->getMessage()}", 'Error');
            throw $e;
        }
    }
}
