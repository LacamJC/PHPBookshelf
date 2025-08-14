<?php

namespace App\Controllers;

use App\Middlewares\AuthMiddleware;
use App\Core\Response;
use App\Database\Connection;
use App\Database\LivroGateway;
use App\Services\LivroService;
use DomainException;
use Exception;

class LivroController
{

    private LivroService $service;

    public function __construct(?LivroService $service = null)
    {
        if ($service === null) {
            $conn = Connection::open($_ENV['CONNECTION_NAME']);
            $gateway = new LivroGateway($conn);
            $service = new LivroService($gateway);
        }
        $this->service = $service;
    }

    public function store(): Response
    {
        AuthMiddleware::handle();
        $dados = $_POST;

        foreach ($dados as $chave => $valor) {
            if (is_string($valor)) {
                $valor = trim($valor);
                if (strlen($valor) == 0 or $valor == '') {
                    return Response::redirect('livros/cadastrar', "O campo {$chave} não pode estar vazio", 'danger');
                }
            }
            if (is_numeric($valor)) {
                if ($valor == 0 or $valor < 0) {
                    if ($chave == 'qtd_paginas') {
                        return Response::redirect('livros/cadastrar', "O numero de páginas não pode conter valores abaixo ou igual a zero", 'danger');
                    } else {
                        return Response::redirect('livros/cadastrar', "O campo {$chave} não pode conter valores abaixo ou igual a zero", 'danger');
                    }
                }
            }
            if ($chave == "nacional") {
                if (!in_array($valor, ['S', 'N', 's', 'n'])) {
                    return Response::redirect('livros/cadastrar', 'Selecione uma origem válida para o livro', 'danger');
                }
            }

            if (is_string($valor)) {
                $dados[$chave] = trim($valor);
            }
        }

        if (!isset($dados['nacional'])) {
            return Response::redirect('livros/cadastrar', 'Selecione uma origem válida para o livro', 'danger');
        }

        if (isset($_FILES['capa_path']) && $_FILES['capa_path']['error'] == 0) {
            $pasta = 'uploads/';
            $image_name = str_replace(' ', '-', trim($_FILES['capa_path']['name']));
            $filename = uniqid() . '-' . $image_name;
            $caminho = $pasta . $filename;

            if (!is_dir($pasta)) {
                mkdir($pasta, 0755, true); // Garante que a pasta exista
            }

            move_uploaded_file($_FILES['capa_path']['tmp_name'], $caminho);

            $dados['capa_path'] = $caminho;
        } elseif (empty($_FILES['capa_path']) || $_FILES['capa_path']['error'] == UPLOAD_ERR_NO_FILE) {
            $dados['capa_path'] = 'uploads/placeholder.png';
        } else {
            return Response::redirect('livros/cadastrar', 'errorMessage', 'Erro ao salvar imagem, tente com outra');
        }

        try {
            $this->service->store($dados);
            return Response::redirect('livros', "Livro {$dados['titulo']} adicionado com sucesso", 'success');
        } catch (Exception $e) {
            return Response::redirect('livros', 'Houve um erro ao inserir o novo livro, por favor tente novamente mais tarde', 'danger');
        }
    }


    public function update(): Response
    {
        AuthMiddleware::handle();
        if (strcmp($_POST['edit_token'], $_ENV['EDIT_TOKEN']) !== 0) {
            return Response::redirect('home', 'Desculpe, você não tem acesso a esse recurso', 'warning');
        }
        $dados = $_POST;

        foreach ($dados as $chave => $valor) {

            if (is_string($valor)) {
                $valor = trim($valor);
                if (strlen($valor) == 0 or $valor == '') {
                    return Response::redirect('livros/editar/' . $dados['id'], "O campo {$chave} não pode estar vazio", "danger");
                }
            }
            if (is_numeric($valor)) {
                if ($valor == 0 or $valor < 0) {
                    if ($chave == 'qtd_paginas') {
                        return Response::redirect('livros/editar/' . $dados['id'], "O numero de páginas não pode conter valores abaixo ou igual a zero", 'danger');
                    } else {
                        return Response::redirect('livros/editar/' . $dados['id'], "O campo {$chave} não pode conter valores abaixo ou igual a zero", 'danger');
                    }
                }
            }
            if ($chave == "nacional") {
                if (!in_array($valor, ['S', 'N', 's', 'n'])) {
                    return Response::redirect('livros/editar/' . $dados['id'], 'Selecione uma origem válida para o livro', 'danger');
                }
            }

            if (is_string($valor)) {
                $dados[$chave] = trim($valor);
            }
        }

        if (!isset($dados['nacional'])) {
            return Response::redirect('livros/editar/' . $dados['id'], 'Selecione uma origem válida para o livro', 'danger');
        }

        if (!empty($_FILES['capa_path']['tmp_name'])) {
            $pasta = 'uploads/';
            $image_name = str_replace(' ', '-', trim($_FILES['capa_path']['name']));
            $filename = uniqid() . '-' . $image_name;
            $caminho = $pasta . $filename;

            if (!is_dir($pasta)) {
                // mkdir($pasta, 0755, true); // Garante que a pasta exista
                // throw new DomainException('A pasta de uploads não existe ' . $pasta);
            }
            move_uploaded_file($_FILES['capa_path']['tmp_name'], "/var/www/html/public/".$caminho);

            $dados['capa_path'] = $caminho;
        } else {
            // Mantém a imagem antiga
            $dados['capa_path'] = $_POST['capa_atual'];
        }

        try {

            $this->service->store($dados);
            return Response::redirect("livros/editar/{$dados['id']}", 'Alterações realizadas com sucesso', 'success');
        } catch (Exception $e) {
            return Response::redirect("livros/editar/{$dados['id']}", 'Desculpe, houve um erro ao realizar as alterações, aguarde alguns instantes e tente novamente', 'danger');
        }
    }

    public function delete($params = [])
    {
        $id = $params['id'] ?? 0;
        $token = $params['token'] ?? '';
        AuthMiddleware::token($token);
        try {
            $result =  $this->service->delete($id);
            if ($result) {
                return Response::redirect('home', 'Livro deletado com sucesso', 'success');
            } else {
                return Response::redirect('home', 'Desculpe, houve um erro ao deletar o livro', 'danger');
            }
        } catch (Exception $e) {
            return Response::redirect('home', 'Desculpe, houve um erro ao deletar o livro', 'danger');
        }
    }
}
