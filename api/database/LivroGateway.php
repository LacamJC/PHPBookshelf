<?php

namespace Api\Database;

use PDO;
use Exception;
use PDOException;

class LivroGateway
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
            // print_r($this->data);
            if (empty($this->data['id'])) {
                $id = $this->getLastId() + 1;
                $sql = "INSERT INTO livros (id, id_usuario, titulo, autores, numero_paginas, genero, nacional, capa_path, editora, descricao)
                VALUES (
                    '{$id}',
                    '{$this->data['id_usuario']}',
                    '{$this->data['titulo']}',
                    '{$this->data['autores']}',
                    '{$this->data['numero_paginas']}',
                    '{$this->data['genero']}',
                    '{$this->data['nacional']}',
                    '{$this->data['capa_path']}',
                    '{$this->data['editora']}',
                    '{$this->data['descricao']}'
                )";
            } else {
                $sql = "UPDATE livros 
                SET 
                    titulo = '{$this->data['titulo']}',
                    autores = '{$this->data['autores']}',
                    numero_paginas = '{$this->data['numero_paginas']}',
                    genero = '{$this->data['genero']}',
                    nacional = '{$this->data['nacional']}',
                    capa_path = '{$this->data['capa_path']}',
                    editora = '{$this->data['editora']}',
                    descricao = '{$this->data['descricao']}'
                    WHERE id = {$this->data['id']}";
            }

            self::$conn->exec($sql);

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
            $sql = "SELECT * FROM livros ORDER BY id DESC LIMIT {$limit} OFFSET {$offset}";

            $result = self::$conn->query($sql);
            return $result->fetchAll(PDO::FETCH_CLASS, __CLASS__);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
