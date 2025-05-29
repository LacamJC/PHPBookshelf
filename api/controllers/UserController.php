<?php

namespace Api\Controllers;


use Api\Core\Response;
use Api\Services\UserService;
use Exception;

class UserController
{

    public function login()
    {
        $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Response::redirect('login', 'Email inválido', 'danger');
        }
        if (strlen($password) < 6) {
            Response::redirect('login', 'A senha deve conter ao menos 6 caracteres',  "danger");
        }

        $user = UserService::verify($email, $password);
    }

    public function logout()
    {
        if ($_SESSION['user']) {
            unset($_SESSION['user']);
            Response::redirect('login', 'Logout efetuado com sucesso', 'warning');
        }else{
            Response::redirect('login');
        }
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

            foreach ($dados as $prop => $value) {
                if (empty($value) or strlen($value) <= 0) {

                    Response::redirect('cadastro', "O campo '{$prop}' nao pode ser vazio", 'danger');
                }
            }
            if ($dados['senha'] !== $dados['confirma']) {
                Response::redirect('cadastro', 'As senhas devem ser identicas', 'danger');
            }

            try {
                unset($dados['confirma']);
                $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

                $result = UserService::store($dados);

                if (!$result) {
                    echo "Erro ao cadastrar usuario";
                }

                // Response::redirect('home');
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
}
