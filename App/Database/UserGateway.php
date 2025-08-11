<?php

namespace App\Database;

use App\Abstract\Gateway;
use App\Models\User;
use PDO;
use Exception;
use PDOException;

class UserGateway extends Gateway
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function save(User $user): bool
    {
        try {
            if (empty($user->id)) {  // <- Verifica se é uma atualização ou inserção
                $id = $this->getLastId()+1; // <- Busca o ultimo id do banco de dados
                $sql = "INSERT INTO usuarios(id, nome, email, senha) VALUES (:id, :nome, :email, :senha)";

            } else {
                $id = $user->id;
                $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
            }

            $stmt = $this->conn->prepare($sql);

            $nome = trim($user->nome);
            $email = trim($user->email);
            $senha = trim($user->senha);

            $stmt->bindValue(':id', $id, self::TYPE_INT);
            $stmt->bindValue(':nome', $nome, self::TYPE_STR);
            $stmt->bindValue(':email', $email, self::TYPE_STR);
            if (empty($user->id)) { // <- So prepara a senha se for um novo usuario
                $stmt->bindValue(':senha', $senha, self::TYPE_STR);
            }

            return $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findById(int $id): ?User
    {
        try {
            $sql = "SELECT id, nome, email FROM usuarios WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':id', $id, self::TYPE_INT);

            $stmt->execute();

            $user =  $stmt->fetchObject(User::class);

            if (!$user) {
                return null;
            }

            return $user;
        } catch (Exception $e) {
            // throw new Exception("Erro ao buscar usuário por ID: " . $e->getMessage());
            throw $e;
        }
    }

    public function findByEmail(string $email): ?User
    {
        try {
            $sql = "SELECT id,nome,senha,email FROM usuarios WHERE email = :email";
            $stmt = $this->conn->prepare($sql);

            $email = trim($email);

            $stmt->bindValue(':email', $email, self::TYPE_STR);

            $stmt->execute();

            $user = $stmt->fetchObject(User::class);

            if (!$user) {
                return null;
            }

            return $user;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findAll(): array
    {
        try {
            $sql = "SELECT id,nome,email FROM usuarios";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, User::class);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function verifyExists(string $email): bool
    {
        try {
            $sql = "SELECT id FROM usuarios WHERE email = :email";

            $stmt = $this->conn->prepare($sql);

            $email = trim($email);

            $stmt->bindValue(':email', $email, self::TYPE_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function userExists(int $id): bool
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE id = :id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':id', $id, self::TYPE_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getLastId(): int
    {
        try {
            $sql = "SELECT max(id) as max FROM usuarios";
            $result = $this->conn->query($sql);
            $data = $result->fetch(PDO::FETCH_OBJ);

            return isset($data->max) ? $data->max : 0;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete($id): bool
    {
        try {
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, self::TYPE_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
