<?php

namespace App\Database;

use App\Abstract\Gateway;
use App\Models\Livro;
use PDO;
use Exception;

class LivroGateway extends Gateway
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function save(Livro $livro): bool
    {
        try {
            if (empty($livro->id)) {
                $id = $this->getLastId() + 1;
                $sql = "INSERT INTO livros
                (id, id_usuario, titulo, autores, numero_paginas, genero, nacional, capa_path, editora, descricao)
                VALUES
                (:id, :id_usuario, :titulo, :autores, :numero_paginas, :genero, :nacional, :capa_path, :editora, :descricao)";
                $stmt = $this->conn->prepare($sql);

                $stmt->bindValue(':id',                 $id, self::TYPE_INT);
                $stmt->bindValue(':id_usuario',         $livro->id_usuario, self::TYPE_INT);
                $stmt->bindValue(':titulo',             $livro->titulo, self::TYPE_STR);
                $stmt->bindValue(':autores',            $livro->autores, self::TYPE_STR);
                $stmt->bindValue(':numero_paginas',     $livro->numero_paginas, self::TYPE_INT);
                $stmt->bindValue(':genero',             $livro->genero, self::TYPE_STR);
                $stmt->bindValue(':nacional',           $livro->nacional, self::TYPE_STR);
                $stmt->bindValue(':capa_path',          $livro->capa_path, self::TYPE_STR);
                $stmt->bindValue(':editora',            $livro->editora, self::TYPE_STR);
                $stmt->bindValue(':descricao',          $livro->descricao, self::TYPE_STR);

                return $stmt->execute();
            } else {
                // Atualização
                $sql = "UPDATE livros SET 
                titulo = :titulo,
                autores = :autores,
                numero_paginas = :numero_paginas,
                genero = :genero,
                nacional = :nacional,
                capa_path = :capa_path,
                editora = :editora,
                descricao = :descricao
                WHERE id = :id";

                $stmt = $this->conn->prepare($sql);

                $stmt->bindValue(':id',                 $livro->id, self::TYPE_INT);
                $stmt->bindValue(':titulo',             $livro->titulo, self::TYPE_STR);
                $stmt->bindValue(':descricao',          $livro->descricao, self::TYPE_STR);
                $stmt->bindValue(':autores',            $livro->autores, self::TYPE_STR);
                $stmt->bindValue(':nacional',           $livro->nacional, self::TYPE_STR);
                $stmt->bindValue(':editora',            $livro->editora, self::TYPE_STR);
                $stmt->bindValue(':capa_path',          $livro->capa_path, self::TYPE_STR);
                $stmt->bindValue(':genero',             $livro->genero, self::TYPE_STR);
                $stmt->bindValue(':numero_paginas',     $livro->numero_paginas, self::TYPE_INT);

                return $stmt->execute();
            }
        } catch (Exception $e) {
            $message = 'LivroGateway@save: ' . $e->getMessage();
            throw $e;
        }
    }

    public function getLastId(): int
    {
        try {
            $sql = "SELECT max(id) as max FROM livros";
            $result = $this->conn->query($sql);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            if (!isset($data['max']) || $data['max'] === null) {
                return 1; 
            }
            
            return $data['max'];
        } catch (Exception $e) {
            $message = 'LivroGateway@getLastId: ' . $e->getMessage();
            error_log($message);
            throw $e;
        }
    }

    public function all(): array
    {
        try {
            $sql = "SELECT * FROM livros";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_CLASS, Livro::class);
        } catch (Exception $e) {
            $message = 'LivroGateway@all: ' . $e->getMessage();
            throw $e;
        }
    }

    public function findById(int $id): ?Livro
    {
        try {
            $sql = "SELECT * FROM livros WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            // die($id);
            $stmt->bindValue(':id', $id, self::TYPE_INT);
            $stmt->execute();
            $livro = $stmt->fetchObject(Livro::class);

            if (!$livro) {
                return null;
            }

            return $livro;
        } catch (Exception $e) {
            $message = 'LivroGateway@findById: ' . $e->getMessage();
            throw $e;
        }
    }

    public function countAll(): int
    {
        try {
            $sql = "SELECT count(*) as max FROM livros";
            $result = $this->conn->query($sql);
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data['max'];
        } catch (Exception $e) {
            $message = 'LivroGateway@countAll: ' . $e->getMessage();
            throw $e;
        }
    }

    public function paginate(int $limit, int $offset): array
    {
        try {
            // $sql = "SELECT * FROM livros ORDER BY id DESC LIMIT :limit OFFSET :offset";
            $sql = "SELECT livros.*, usuarios.nome as nome_usuario FROM livros LEFT JOIN usuarios ON livros.id_usuario = usuarios.id ORDER BY livros.id DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, self::TYPE_INT);
            $stmt->bindValue(':offset', $offset, self::TYPE_INT);

            $stmt->execute();
            // $livros = $stmt->fetchAll(PDO::FETCH_CLASS, Livro::class);
            // die();
            return $stmt->fetchAll(PDO::FETCH_CLASS, Livro::class);
        } catch (Exception $e) {
            $message = 'LivroGateway@paginate: ' . $e->getMessage();
            throw $e;
        }
    }

    public function delete(int $id): bool
    {
        try {

            $sql = "DELETE FROM livros WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, self::TYPE_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            $message = 'LivroGateway@delete: ' . $e->getMessage();
            throw $e;
        }
    }
}
