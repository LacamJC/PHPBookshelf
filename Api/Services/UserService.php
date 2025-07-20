<?php

namespace Api\Services;

use Api\Abstract\Logger;
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
            $conn = Connection::open($_ENV['CONNECTION_NAME']);
            UserGateway::setConnection($conn);

            $user = new UserGateway($dados['nome'], $dados['email'], $dados['senha']);
            if (isset($dados['id'])) {
                $user->id = $dados['id'];
            }


            $user->save();

            if (isset($dados['id'])) {
                $logged = new stdClass();
                $logged->id = $dados['id'];
                $logged->nome = $dados['nome'];
                $logged->email = $dados['email'];
                unset($_SESSION['user']);
                $_SESSION['user'] = $logged;


                LoggerTXT::log("UserService@store: Usuario com o email {$dados['email']} atualizado", "Success");
                return Response::redirect('login', 'Cadastro efetuado com sucesso', 'success');
            }

            LoggerTXT::log("UserService@store: Novo usuário com o email {$dados['email']}", "Success");
            return Response::redirect('login', 'Cadastro efetuado com sucesso', 'success');
        } catch (Exception $e) {
            LoggerTXT::log("UserService@store: {$e->getMessage()}", 'Error');
            Response::redirect(
                'login',
                'Desculpe houve um erro ao efetuar a operação, tente novamente em instantes',
                'danger'
            );
        }
    }

    public static function delete($id)
    {
        try {
            if ($id == null) {
                throw new Exception("Impossivel deletar usuario com ID inválido: {$id}");
            }
            $conn = Connection::open($_ENV['CONNECTION_NAME']);
            UserGateway::setConnection(($conn));
            $result =  UserGateway::delete($id);
            LoggerTXT::log("Usuário {$id} deletado com sucesso", 'Success');
            if (isset($_SESSION['user'])) {
                unset($_SESSION['user']);
                unset($_SESSION['form_data']);
            }
            Response::redirect('login', 'Conta apagada com sucesso', 'success');
        } catch (Exception $e) {
            LoggerTXT::log('UserService@delete: ' . $e->getMessage(), 'Error');
            Response::redirect('login', 'Erro ao deletar usuario', 'danger');
        }
    }

    public static function findById($id)
    {
        try {
            if ($id == null) {
                throw new Exception("Impossivel deletar usuario com ID inválido: {$id}");
            }
            $conn = Connection::open($_ENV['CONNECTION_NAME']);
            UserGateway::setConnection(($conn));

            $user = UserGateway::findById($id);

            return $user;
        } catch (Exception $e) {
            LoggerTXT::log('UserService@findById: ' . $e->getMessage(), 'Error');
            Response::redirect('home');
        }
    }


    public static function verify($email, $pass)
    {
        try {
            $conn = Connection::open($_ENV['CONNECTION_NAME']);
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


            LoggerTXT::log("UserService@verify: O usuário {$logged->email} fez login", "Success");
            Response::redirect('home');
        } catch (Exception $e) {
            LoggerTXT::log("UserService@verify: {$e->getMessage()}", 'Error');
            Response::redirect('login', 'Desculpe houve um erro ao efetuar seu login, tente novamente', 'warning');
        }
    }
}
