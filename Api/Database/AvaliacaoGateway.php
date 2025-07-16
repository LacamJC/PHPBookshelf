<?php

namespace Api\Database;

use Api\Abstract\Gateway;
use Api\Core\LoggerTXT;
use PDO;
use Exception;
use PDOException;

class AvaliacaoGateway extends Gateway
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
            if (!empty($this->data['id'])) {
                // Atualiza avaliação existente
                $sql = "UPDATE avaliacoes SET 
                            id_usuario = :id_usuario,
                            id_livro = :id_livro,
                            comentario = :comentario,
                            nota = :nota
                        WHERE id = :id";
                $stmt = self::$conn->prepare($sql);
                $stmt->bindValue(':id_usuario', $this->data['id_usuario'], PDO::PARAM_INT);
                $stmt->bindValue(':id_livro', $this->data['id_livro'], PDO::PARAM_INT);
                $stmt->bindValue(':comentario', $this->data['comentario'], PDO::PARAM_STR);
                $stmt->bindValue(':nota', $this->data['nota'], PDO::PARAM_INT);
                $stmt->bindValue(':id', $this->data['id'], PDO::PARAM_INT);
                echo $sql;
                die();
                return $stmt->execute();
            } else {
                // Insere nova avaliação
                $sql = "INSERT INTO avaliacoes (id_usuario, id_livro, comentario, nota, created_at)
                        VALUES (:id_usuario, :id_livro, :comentario, :nota, CURRENT_TIMESTAMP)";
                $stmt = self::$conn->prepare($sql);
                $stmt->bindValue(':id_usuario', $this->data['id_usuario'], PDO::PARAM_INT);
                $stmt->bindValue(':id_livro', $this->data['id_livro'], PDO::PARAM_INT);
                $stmt->bindValue(':comentario', $this->data['comentario'], PDO::PARAM_STR);
                $stmt->bindValue(':nota', $this->data['nota'], PDO::PARAM_INT);

                $result = $stmt->execute();
                if ($result) {
                    $this->data['id'] = self::$conn->lastInsertId();
                }
                return $result;
            }
        } catch (PDOException $e) {
            LoggerTXT::log("Erro no save da avaliação: " . $e->getMessage(), 'Error');
            return false;
        }
    }

    public function usuarioJaComentou()
    {
        try {
            echo $this->id_usuario;
            echo "<br>";
            echo $this->id_livro;

            $sql = "SELECT id FROM avaliacoes WHERE id_usuario = :id_usuario AND id_livro = :id_livro";
            $stmt = self::$conn->prepare($sql);

            $stmt->bindValue(':id_usuario', $this->id_usuario, self::TYPE_INT);
            $stmt->bindValue(':id_livro', $this->id_livro, self::TYPE_INT);

            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }
    }


    public static function comentarios($id)
    {
        try {
            $sql = "SELECT avaliacoes.id, usuarios.id as id_usuario, usuarios.nome, avaliacoes.comentario, avaliacoes.nota, livros.titulo FROM avaliacoes INNER JOIN usuarios ON avaliacoes.id_usuario = usuarios.id JOIN livros ON livros.id = :id_livro WHERE avaliacoes.id_livro = :id_livro";

            $stmt = self::$conn->prepare($sql);

            $stmt->bindValue(':id_livro', $id, self::TYPE_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        throw $e;
    }


    public function getLastId()
    {
        try {
            $sql = "SELECT max(id) as max FROM avaliacoes";
            $result = self::$conn->query($sql);
            $data = $result->fetch(PDO::FETCH_OBJ);
            return $data->max;
        } catch (Exception $e) {
            throw $e;
        }
    }


    public static function findById($id)
    {
        try {
            $sql = "SELECT * FROM avaliacoes WHERE id_livro = :id";
            $stmt = self::$conn->prepare($sql);

            $stmt->bindValue(':id', $id, self::TYPE_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function findByIdLivro($id)
    {
        try {
            $sql = "SELECT * FROM avaliacoes WHERE id = :id";
            $stmt = self::$conn->prepare($sql);

            $stmt->bindValue(':id', $id, self::TYPE_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }
    }


    public static function countAll($id)
    {
        try {
            $sql = "SELECT count(*) as max FROM avaliacoes WHERE id_livro = :id";

            $stmt = self::$conn->prepare($sql);

            $stmt->bindValue(':id', $id, self::TYPE_INT);
            $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_OBJ);
            return $data->max;
        } catch (Exception $e) {
            // echo $e->getMessage();
            throw $e;
        }
    }

    public static function delete($id)
    {
        try {

            $sql = "DELETE FROM avaliacoes WHERE id = :id";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindValue(':id', $id, self::TYPE_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
