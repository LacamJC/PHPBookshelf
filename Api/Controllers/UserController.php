<?php

namespace Api\Controllers;

use Api\Core\LoggerTXT;
use Api\Core\Response;
use Api\Database\Connection;
use Api\Database\UserGateway;
use Api\Middlewares\AuthMiddleware;
use Api\Services\AuthService;
use Api\Services\UserService;
use Exception;
use InvalidArgumentException;

class UserController
{
    private UserService $service;
    private AuthService $auth;

    public function __construct(?UserService $service = null, ?AuthService $auth = null)
    {
        if ($service === null) {
            $conn = Connection::open($_ENV['CONNECTION_NAME']);
            $gateway = new UserGateway($conn);
            $service = new UserService($gateway);
        }

        if ($auth === null) {
            $auth = new AuthService;
        }

        $this->service = $service;
        $this->auth = $auth;
    }

    public function login(): Response
    {
        AuthMiddleware::token($_POST['edit_token']);

        $this->auth->setForm($_POST);

        $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return Response::redirect('login', 'Email inválido', 'danger');
        }
        if (strlen($password) < 6) {
            return Response::redirect('login', 'A senha deve conter ao menos 6 caracteres',  "danger");
        }
        if (strlen($password) > 12) {
            return Response::redirect('login', 'A senha não deve conter mais que 12 caracteres', 'danger');
        }

        try {
            $valid = $this->service->verify($email, $password);

            if ($valid) {
                $this->auth->clearForm();
                LoggerTXT::log("{$_SESSION['user']->nome} fez login", 'Login');
                return Response::redirect('home');
            } else {
                return Response::redirect('login', 'Desculpe, houve um erro ao realizar login, tente novamente mais tarde', 'warning');
            }
        } catch (InvalidArgumentException $e) {
            return Response::redirect('login', $e->getMessage(), 'danger');
        } catch (\Exception $e) {
            return Response::redirect('login', 'Desulpe, houve um erro interno no sistema, por favor tente novamente mais tarde', 'warning');
        }
    }

    public function logout(): Response
    {
        LoggerTXT::log("{$_SESSION['user']->nome} fez logout", 'Logout');
        $this->auth->logout();
        return Response::redirect('login');
    }

    public function delete(array $params = []): Response
    {
        AuthMiddleware::handle();
        $id = (int) $params['id'];
        $token = $params['token'];
        AuthMiddleware::token($token);

        if ($id <= 0) {
            Response::redirect('login', '', '');
        }
        try {
            $this->service->delete($id);
            return Response::redirect('login', 'Conta apagada com sucesso', 'success');
        } catch (\Exception $e) {
            LoggerTXT::log("Erro ao apagar usuário: {$e->getMessage()}", 'Error');
            return Response::redirect('home', 'Houve um erro interno no sistema, por favor tente novamente mais tarde', 'danger');
        }
    }

    public function store(): Response
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome'     => (trim($_POST['nome']))    ?? '',
                'senha'    => (trim($_POST['senha']))   ?? '',
                'email'    => (trim($_POST['email']))   ?? '',
                'confirma' => (trim($_POST['confirma']) ?? '')
            ];

            $this->auth->setForm($_POST);
            AuthMiddleware::token($_POST['edit_token']);
            foreach ($dados as $prop => $value) {
                if (empty($value) || strlen($value) <= 0) {
                    return Response::redirect('cadastro', "O campo '{$prop}' nao pode ser vazio", 'danger');
                }
            }
            try {
                $this->service->save($dados);
                return Response::redirect('login', 'Conta cadastrada com sucesso', 'success');
            } catch (InvalidArgumentException $e) {
                return response::redirect('cadastro', $e->getMessage(), 'danger');
            } catch (\Exception $e) {
                return Response::redirect('cadastro', 'Desculpe, houve um erro interno ao realizar o seu cadastro, tente novamente mais tarde', 'danger');
            }
        } else {
            return Response::redirect('login', 'Método de envio inválido', 'danger');
        }
    }

    public function edit(array $params = []): Response
    {
        $token = $params['token'];
        $id = $params['id'];
        AuthMiddleware::handle();
        AuthMiddleware::token($token);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome'     => (trim($_POST['nome']))    ?? '',
                'senha'    => (trim($_POST['senha']))   ?? '',
                'email'    => (trim($_POST['email']))   ?? '',
                'confirma' => (trim($_POST['confirma']) ?? '')
            ];
            foreach ($dados as $prop => $value) {
                if (empty($value) || strlen($value) <= 0) {
                    return Response::redirect("usuarios/editar-conta/$id/$token", "O campo '{$prop}' nao pode ser vazio", 'danger');
                }
            }
            if ($dados['senha'] !== $dados['confirma']) {
                return Response::redirect("usuarios/editar-conta/$id/$token", 'As senhas devem ser identicas', 'danger');
            }
            unset($dados['confirma']);

            $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

            unset($dados['edit_token']);

            $dados['id'] = $id;

            try {
                $this->service->update($dados);
            } catch (InvalidArgumentException $e) {
                return Response::redirect("usuarios/editar-conta/$id/$token", $e->getMessage(), 'warning');
            } catch (Exception $e) {
                return Response::redirect("usuarios/editar-conta/$id/$token", 'Houve um erro interno no servidor, por favor tente novamente mais tarde.', 'danger');
            }
            return Response::redirect("usuarios/editar-conta/$id/$token", 'Conta atualizada com sucesso', 'success');
        } else {
            return Response::redirect("usuarios/editar-conta/$id/$token", 'Método de envio inválido', 'danger');
        }
    }
}