<?php

namespace Api\Database;

use Api\Abstract\Gateway;
use PDO;
use Exception;

class LivroGateway extends Gateway
{
    private array $data = [];
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function __set($prop, $value)
    {
        $this->data[$prop] = $value;
    }

    public function __get($prop)
    {
        return $this->data[$prop];
    }

    public function save(): bool
    {
        try {
            if (empty($this->data['id'])) {
                $id = $this->getLastId() + 1;
                $sql = "INSERT INTO livros 
                (id, id_usuario, titulo, autores, numero_paginas, genero, nacional, capa_path, editora, descricao)
                VALUES
                (:id, :id_usuario, :titulo, :autores, :numero_paginas, :genero, :nacional, :capa_path, :editora, :descricao)";
                $stmt = $this->conn->prepare($sql);

                $stmt->bindValue(':id', $id, self::TYPE_INT);
                $stmt->bindValue(':id_usuario', $this->data['id_usuario'], self::TYPE_INT);
                $stmt->bindValue(':titulo', $this->data['titulo'], self::TYPE_STR);
                $stmt->bindValue(':autores', $this->data['autores'], self::TYPE_STR);
                $stmt->bindValue(':numero_paginas', $this->data['numero_paginas'], self::TYPE_INT);
                $stmt->bindValue(':genero', $this->data['genero'], self::TYPE_STR);
                $stmt->bindValue(':nacional', $this->data['nacional'], self::TYPE_STR);
                $stmt->bindValue(':capa_path', $this->data['capa_path'], self::TYPE_STR);
                $stmt->bindValue(':editora', $this->data['editora'], self::TYPE_STR);
                $stmt->bindValue(':descricao', $this->data['descricao'], self::TYPE_STR);

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

                $stmt->bindValue(':titulo', $this->data['titulo'], self::TYPE_STR);
                $stmt->bindValue(':autores', $this->data['autores'], self::TYPE_STR);
                $stmt->bindValue(':numero_paginas', $this->data['numero_paginas'], self::TYPE_INT);
                $stmt->bindValue(':genero', $this->data['genero'], self::TYPE_STR);
                $stmt->bindValue(':nacional', $this->data['nacional'], self::TYPE_STR);
                $stmt->bindValue(':capa_path', $this->data['capa_path'], self::TYPE_STR);
                $stmt->bindValue(':editora', $this->data['editora'], self::TYPE_STR);
                $stmt->bindValue(':descricao', $this->data['descricao'], self::TYPE_STR);
                $stmt->bindValue(':id', $this->data['id'], self::TYPE_INT);

                return $stmt->execute();
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getLastId(): int
    {
        try {
            $sql = "SELECT max(id) as max FROM livros";
            $result = $this->conn->query($sql);
            $data = $result->fetch(PDO::FETCH_OBJ);
            return $data->max;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function all(): array
    {
        try {
            $sql = "SELECT * FROM livros";
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findById(int $id)
    {
        try {
            $sql = "SELECT * FROM livros WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':id', $id, self::TYPE_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function countAll(): int
    {
        try {
            $sql = "SELECT count(*) as max FROM livros";
            $result = $this->conn->query($sql);
            $data = $result->fetch(PDO::FETCH_OBJ);
            return $data->max;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function paginate(int $limit, int $offset): array
    {
        try {
            $sql = "SELECT * FROM livros ORDER BY id DESC LIMIT :limit OFFSET :offset";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, self::TYPE_INT);
            $stmt->bindValue(':offset', $offset, self::TYPE_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
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
            throw $e;
        }
    }
}
