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
            Response::redirect('login', 'errorMessage',  'Email inválido');
        }
        if (strlen($password) < 6) {
            Response::redirect('login', 'errorMessage',  "A senha deve conter ao menos 6 caracteres");
        }

        $user = UserService::verify($email, $password);
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

                    Response::redirect('cadastro', 'errorMessage', "O campo '{$prop}' nao pode ser vazio");
                }
            }
            if ($dados['senha'] !== $dados['confirma']) {
                Response::redirect('cadastro', 'errorMessage', 'As senhas devem ser identicas');
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
