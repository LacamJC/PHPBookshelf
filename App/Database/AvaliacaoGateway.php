<?php

namespace App\Database;

use App\Abstract\Gateway;
use App\Core\LoggerTXT;
use App\Models\Avaliacao;
use PDO;
use Exception;
use PDOException;
use stdClass;

class AvaliacaoGateway extends Gateway
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function save(Avaliacao $avaliacao): bool
    {
        try {
            if (!empty($avaliacao->id)) {
                // Atualiza avaliação existente
                $sql = "UPDATE avaliacoes SET
                            id_usuario = :id_usuario,
                            id_livro = :id_livro,
                            comentario = :comentario,
                            nota = :nota
                        WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':id_usuario', $avaliacao->id_usuario, PDO::PARAM_INT);
                $stmt->bindValue(':id_livro', $avaliacao->id_livro, PDO::PARAM_INT);
                $stmt->bindValue(':comentario', $avaliacao->comentario, PDO::PARAM_STR);
                $stmt->bindValue(':nota', $avaliacao->nota, PDO::PARAM_INT);
                $stmt->bindValue(':id', $avaliacao->id, PDO::PARAM_INT);

                return $stmt->execute();
            } else {
                // Insere nova avaliação
                $sql = "INSERT INTO avaliacoes (id_usuario, id_livro, comentario, nota, created_at)
                        VALUES (:id_usuario, :id_livro, :comentario, :nota, CURRENT_TIMESTAMP)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindValue(':id_usuario', $avaliacao->id_usuario, PDO::PARAM_INT);
                $stmt->bindValue(':id_livro', $avaliacao->id_livro, PDO::PARAM_INT);
                $stmt->bindValue(':comentario', $avaliacao->comentario, PDO::PARAM_STR);
                $stmt->bindValue(':nota', $avaliacao->nota, PDO::PARAM_INT);

                return $stmt->execute();
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


    public function comentarios($id)
    {
        try {
            $sql = "SELECT avaliacoes.id, usuarios.id as id_usuario, usuarios.nome, avaliacoes.comentario, avaliacoes.nota, livros.titulo FROM avaliacoes INNER JOIN usuarios ON avaliacoes.id_usuario = usuarios.id JOIN livros ON livros.id = :id_livro WHERE avaliacoes.id_livro = :id_livro";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':id_livro', $id, self::TYPE_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            throw $e;
        }
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


    public function findById($id): stdClass | bool
    {
        try {
            $sql = "SELECT * FROM avaliacoes WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

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

    public function delete($id): bool
    {
        try {

            $sql = "DELETE FROM avaliacoes WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, self::TYPE_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
