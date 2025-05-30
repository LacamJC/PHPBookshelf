<?php

namespace Api\Database;

use Api\Abstract\Gateway;
use PDO;
use Exception;
use PDOException;

class LivroGateway extends Gateway
{
    private static $conn;
    private $data;

    public function __set($prop, $value)
    {
        $this->data[$prop] = $value;
    }

    public function __get($prop)
    {
        return $this->data[$prop];
    }


    public static function setConnection(PDO $conn)
    {
        self::$conn = $conn;
    }

    public function save()
    {
        try {
            if (empty($this->data['id'])) {
                // Inserção
                $id = $this->getLastId() + 1;
                $sql = "INSERT INTO livros 
                (id, id_usuario, titulo, autores, numero_paginas, genero, nacional, capa_path, editora, descricao)
                VALUES
                (:id, :id_usuario, :titulo, :autores, :numero_paginas, :genero, :nacional, :capa_path, :editora, :descricao)";

                $stmt = self::$conn->prepare($sql);

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

                $stmt->execute();
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

                $stmt = self::$conn->prepare($sql);

                $stmt->bindValue(':titulo', $this->data['titulo'], self::TYPE_STR);
                $stmt->bindValue(':autores', $this->data['autores'], self::TYPE_STR);
                $stmt->bindValue(':numero_paginas', $this->data['numero_paginas'], self::TYPE_INT);
                $stmt->bindValue(':genero', $this->data['genero'], self::TYPE_STR);
                $stmt->bindValue(':nacional', $this->data['nacional'], self::TYPE_STR);
                $stmt->bindValue(':capa_path', $this->data['capa_path'], self::TYPE_STR);
                $stmt->bindValue(':editora', $this->data['editora'], self::TYPE_STR);
                $stmt->bindValue(':descricao', $this->data['descricao'], self::TYPE_STR);
                $stmt->bindValue(':id', $this->data['id'], self::TYPE_INT);

                $stmt->execute();
            }

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function getLastId()
    {
        try {
            $sql = "SELECT max(id) as max FROM livros";
            $result = self::$conn->query($sql);
            $data = $result->fetch(PDO::FETCH_OBJ);
            return $data->max;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function all()
    {
        try {
            $sql = "SELECT * FROM livros";

            $result = self::$conn->query($sql);
            return $result->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function findById($id)
    {
        try {
            $sql = "SELECT * FROM livros WHERE id = :id";
            $stmt = self::$conn->prepare($sql);

            $stmt->bindValue(':id', $id, self::TYPE_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function countAll()
    {
        try {
            $sql = "SELECT count(*) as max FROM livros";
            $result = self::$conn->query($sql);
            $data = $result->fetch(PDO::FETCH_OBJ);
            return $data->max;
        } catch (Exception $e) {
            // echo $e->getMessage();
            throw $e;
        }
    }

    public static function paginate($limit, $offset)
    {
        try {
            $sql = "SELECT * FROM livros ORDER BY id DESC LIMIT :limit OFFSET :offset";

            $stmt = self::$conn->prepare($sql);
            $stmt->bindValue(':limit', $limit, self::TYPE_INT);
            $stmt->bindValue(':offset', $offset, self::TYPE_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function delete($id)
    {
        try {

            $sql = "DELETE FROM livros WHERE id = :id";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindValue(':id', $id, self::TYPE_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
