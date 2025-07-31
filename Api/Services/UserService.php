<?php

namespace Api\Services;

use Api\Core\LoggerTXT;
use Api\Database\UserGateway;
use Api\Database\Connection;
use Api\Models\User;
use Exception;
use InvalidArgumentException;

class UserService
{

    private UserGateway $gateway;
    private AuthService $auth;
    public function __construct(?UserGateway $gateway = null, ?AuthService $auth = null)
    {
        if ($gateway === null) {
            $conn = Connection::open($_ENV['CONNECTION_NAME']);
            $gateway = new UserGateway($conn);
        }

        if ($auth === null) {
            $auth = new AuthService;
        }

        $this->gateway = $gateway;
        $this->auth = $auth;
    }

    public function save(array $dados): bool
    {
        try {
            if (strlen($dados['senha']) < 6 || strlen($dados['senha']) > 12) {
                throw new InvalidArgumentException('A senha deve ter mais de 6 caracteres e menos que 12');
            }

            if ($dados['senha'] !== $dados['confirma']) {
                throw new InvalidArgumentException('As senhas devem ser identicas');
            }
            unset($dados['confirma']);

            $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

            $user = new User($dados);
            $result = $this->gateway->save($user);


            if (!$result) {
                throw new Exception('Houve um erro ao salvar o usuário');
            }

            LoggerTXT::log("UserService@store: Novo usuário com o email {$dados['email']}", "Success");
            return $result;
        } catch (Exception $e) {
            LoggerTXT::log("UserService@store: {$e->getMessage()}", 'Error');

            throw $e;
        }
    }

    public function update(array $dados): bool
    {
        try {
            $user = new User($dados);
            if ($user->id == null) {
                throw new InvalidArgumentException('Credenciais inválidas');
            }
            // regerio@gmail.com - dados
            $user_request = $this->gateway->findById($user->id); // adamasteu@gmail.com
            $user_email = $this->gateway->findByEmail($user->email);

            if ($user_email && $user_request->id !==  $user_email->id) {
                throw new InvalidArgumentException('Este email não esta disponivel');
            }


            $result = $this->gateway->save($user);
            $this->auth->clearForm();
            $this->auth->persistUserSession($user);

            if (!$result) {
                throw new Exception('Houve um erro ao atualizar o usuário');
            }

            LoggerTXT::log("UserService@store: Usuário {$dados['email']} atualizado com sucesso", "Success");
            return $result;
        } catch (Exception $e) {
            LoggerTXT::log("UserService@store: {$e->getMessage()}", 'Error');
            throw $e;
        }
    }

    public function delete(int $id): bool
    {
        try {
            if ($id == null || $id < 1) {
                throw new Exception("Impossivel deletar usuario com ID inválido: {$id}");
            }

            $result =  $this->gateway->delete($id);
            if ($result) {
                $this->auth->logout();
            } else {
                throw new Exception('Houve um erro ao deletar o usuário');
            }
            return $result;
        } catch (Exception $e) {
            LoggerTXT::log('UserService@delete: ' . $e->getMessage(), 'Error');
            throw $e;
        }
    }

    public function findById(int $id): User
    {
        try {
            if ($id === null || $id < 1) {
                throw new Exception("ID inválido: {$id}");
            }

            $user = $this->gateway->findById($id);

            if (!$user) {
                throw new  Exception('Usuário não encontrado');
            }

            return $user;
        } catch (Exception $e) {
            LoggerTXT::log('UserService@findById: ' . $e->getMessage(), 'Error');
            throw $e;
        }
    }
    public function findByEmail(string $email): User
    {
        try {
            if ($email === null || strlen($email) < 1) {
                throw new Exception("Email inválido");
            }

            $user = $this->gateway->findByEmail($email);

            if (!$user) {
                throw new  Exception('Usuário não encontrado');
            }

            return $user;
        } catch (Exception $e) {
            LoggerTXT::log('UserService@findByEmail: ' . $e->getMessage(), 'Error');
            throw $e;
        }
    }


    public function verify(string $email, string $pass): bool
    {
        try {
            if (empty($email) || empty($pass)) {
                throw new Exception('Parametros de busca inválidos');
            }

            $user = $this->gateway->findByEmail($email);

            if (!$user) {
                throw new Exception('Usuário não encontrado');
            }

            if (!password_verify($pass, $user->senha)) {
                throw new InvalidArgumentException('Login inválido');
            }


            $this->auth->clearForm();
            $this->auth->persistUserSession($user);

            LoggerTXT::log("UserService@verify: O usuário {$user->email} fez login", "Success");
            return true;
        } catch (Exception $e) {
            LoggerTXT::log("UserService@verify: {$e->getMessage()}", 'Error');
            throw $e;
        }
    }
}
