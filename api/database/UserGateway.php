<?php

namespace Api\Database;

use Api\Abstract\Gateway;
use Api\Core\LoggerTXT;
use PDO;
use Exception;
use PDOException;

class UserGateway extends Gateway
{
    private static $conn;
    private $data;
    private $nome;
    private $email;
    private $senha;

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

    public function __construct(string $nome, string $email, string $senha)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }

    public function save()
    {
        try {
            if (empty($this->data['id'])) {  // <- Verifica se é uma atualização ou inserção

                // if (self::verifyExists($this->email, $this->senha)) { // <- Se o email ja existir lança uma excessão
                //     throw new Exception("Gateway: Email ja cadastrado");
                // }
                $id = $this->getLastId() + 1; // <- Busca o ultimo id do banco de dados
                $sql = "INSERT INTO usuarios(id, nome, email, senha) VALUES (:id, :nome, :email, :senha)";
            } else {
                $id = $this->data['id'];
                $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
            }
            // echo $sql;
            // die();
            $stmt = self::$conn->prepare($sql);

            $nome = trim($this->nome);
            $email = trim($this->email);
            $senha = trim($this->senha);

            $stmt->bindValue(':id', $id, self::TYPE_INT);
            $stmt->bindValue(':nome', $nome, self::TYPE_STR);
            $stmt->bindValue(':email', $email, self::TYPE_STR);
            if (empty($this->data['id'])) { // <- So prepara a senha se for um novo usuario
                $stmt->bindValue(':senha', $senha, self::TYPE_STR);
            }

            $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function findById($id)
    {
        try {
            $sql = "SELECT id, nome, email FROM usuarios WHERE id = :id";
            $stmt = self::$conn->prepare($sql);

            $stmt->bindValue(':id', $id, self::TYPE_INT);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar usuário por ID: " . $e->getMessage());
        }
    }

    public static function findByEmail($email)
    {
        try {
            $sql = "SELECT id,nome,senha,email FROM usuarios WHERE email = :email";
            $stmt = self::$conn->prepare($sql);

            $email = trim($email);

            $stmt->bindValue(':email', $email, self::TYPE_STR);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function findAll()
    {
        try {
            $sql = "SELECT id,nome,email FROM usuarios";
            $stmt = self::$conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function verifyExists($email)
    {
        try {
            $sql = "SELECT id FROM usuarios WHERE email = :email";

            $stmt = self::$conn->prepare($sql);

            $email = trim($email);

            $stmt->bindValue(':email', $email, self::TYPE_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function userExists($id)
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE id = :id";
            $stmt = self::$conn->prepare($sql);

            $stmt->bindValue(':id', $id, self::TYPE_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getLastId()
    {
        try {
            $sql = "SELECT max(id) as max FROM usuarios";
            $result = self::$conn->query($sql);
            $data = $result->fetch(PDO::FETCH_OBJ);
            return $data->max;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function delete($id)
    {
        try {
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindValue(':id', $id, self::TYPE_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
