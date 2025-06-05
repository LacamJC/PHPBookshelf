<?php

namespace Api\Controllers;

use Api\Core\LoggerTXT;
use Api\Core\Response;
use Api\Middlewares\AuthMiddleware;
use Api\Services\UserService;


class UserController
{

    public function login()
    {
        $_SESSION['form_data'] = $_POST;
        AuthMiddleware::token($_POST['edit_token']);
        $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response::redirect('login', 'Email inválido', 'danger');
        }
        if (strlen($password) < 6) {
            return response::redirect('login', 'A senha deve conter ao menos 6 caracteres',  "danger");
        }
        unset($_SESSION['form_data']);
        UserService::verify($email, $password);
    }

    public function logout()
    {
        if ($_SESSION['user']) {
            LoggerTXT::log("{$_SESSION['user']->nome} fez logout", 'Logout');
            unset($_SESSION['user']);
            return response::redirect('login');
        } else {
            return response::redirect('login');
        }
    }

    public function delete($params = [])
    {
        $id = (int) $params['id'];
        $token = $params['token'];
        AuthMiddleware::handle();
        AuthMiddleware::token($token);
        if ($id <= 0 or is_string($id)) {
            Response::redirect('login', '', '');
        }

        UserService::delete($id);
    }


    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'nome'     => (trim($_POST['nome']))    ?? '',
                'senha'    => (trim($_POST['senha']))   ?? '',
                'email'    => (trim($_POST['email']))   ?? '',
                'confirma' => (trim($_POST['confirma']) ?? '')
            ];
            $_SESSION['form_data'] = $_POST;
            AuthMiddleware::token($_POST['edit_token']);
            foreach ($dados as $prop => $value) {
                if (empty($value) or strlen($value) <= 0) {

                    return response::redirect('cadastro', "O campo '{$prop}' nao pode ser vazio", 'danger');
                }
            }
            if ($dados['senha'] !== $dados['confirma']) {
                return response::redirect('cadastro', 'As senhas devem ser identicas', 'danger');
            }

            unset($dados['confirma']);

            $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

            UserService::store($dados);
            return response::redirect('login', 'Conta cadastrada com sucesso', 'success');
        }
    }

    public function edit($params = [])
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
                if (empty($value) or strlen($value) <= 0) {

                    return response::redirect("usuarios/editar-conta/$id/$token", "O campo '{$prop}' nao pode ser vazio", 'danger');
                }
            }
            if ($dados['senha'] !== $dados['confirma']) {
                return response::redirect('cadastro', 'As senhas devem ser identicas', 'danger');
            }
            unset($dados['confirma']);

            $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);


            unset($dados['edit_token']);
            
            $dados['id'] = $id;
            UserService::store($dados);
            return response::redirect('login', 'Conta cadastrada com sucesso', 'success');
        }
    }
}
