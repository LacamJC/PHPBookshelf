<?php

namespace Api\Services;

use Api\Core\LoggerTXT;
use Api\Database\UserGateway;
use Api\Database\Connection;
use Api\Core\Response;
use Exception;
use stdClass;

class UserService
{
    public static function store($dados)
    {
        try {
            $conn = Connection::open('database');
            UserGateway::setConnection($conn);

            $user = new UserGateway($dados['nome'], $dados['email'], $dados['senha']);
            $user->save();

            Response::redirect('login', 'Cadastro efetuado com sucesso', 'success');
        } catch (Exception $e) {
            LoggerTXT::log("UserService@store: {$e->getMessage()}", 'Error');
            Response::redirect('login', 'Desculpe houve um erro ao efetuar a operação, tente novamente em instantes', 
            'danger');
        }
    }

    public static function delete($id)
    {
        Response::redirect('login', 'servico não implementado', 'danger');
    }

    public static function verify($email, $pass)
    {
        try {
            $conn = Connection::open('database');
            UserGateway::setConnection(($conn));
            $user = UserGateway::findByEmail($email);

            if (!password_verify($pass, $user['senha'])) {
                unset($user['senha']);
                Response::redirect('login', 'Usuário não encontrado por favor verifique as informações', 'warning');
            }
            unset($user['senha']);
            unset($_SESSION['form_data']);
            $logged = new stdClass();
            $logged->id = $user['id'];
            $logged->nome = $user['nome'];
            $logged->email = $user['email'];

            $_SESSION['user'] = $logged;

            Response::redirect('home');
        } catch (Exception $e) {
            LoggerTXT::log("UserService@verify: {$e->getMessage()}", 'Error');
            Response::redirect('login', 'Desculpe houve um erro ao efetuar seu login, tente novamente', 'warning');
        }
    }
}
