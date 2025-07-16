<?php

namespace Api\Controllers;

use Api\Core\LoggerTXT;
use Api\Middlewares\AuthMiddleware;
use Api\Core\Response;
use Api\Services\LivroService;


class LivroController
{
    public function store()
    {
        AuthMiddleware::handle();
        $dados = $_POST;

        die('teste');

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

        LivroService::store($dados);
        LoggerTXT::log('LivroController@store: Livro "' . $dados['titulo'] . '" adicionado com sucesso', 'Success');
        Response::redirect('livros', "Livro {$dados['titulo']} adicionado com sucesso", 'success');
    }


    public function update()
    {
        AuthMiddleware::handle();
        if (strcmp($_POST['edit_token'], $_ENV['EDIT_TOKEN']) !== 0) {
            return Response::redirect('home', 'Desculpe, você não tem acesso a esse recurso', 'warning');
        }
        $dados = $_POST;

        // Validando informações do formulario
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
                mkdir($pasta, 0755, true); // Garante que a pasta exista
            }

            move_uploaded_file($_FILES['capa_path']['tmp_name'], $caminho);

            $dados['capa_path'] = $caminho;
        } else {
            // Mantém a imagem antiga
            $dados['capa_path'] = $_POST['capa_atual'];
        }

        LivroService::store($dados);
        Response::redirect("livros/editar/{$dados['id']}", 'Alterações realizadas com sucesso', 'success');
    }

    public function delete($params = [])
    {
        $id = $params['id'] ?? 0;
        $token = $params['token'] ?? '';
        AuthMiddleware::token($token);
        LivroService::delete($id);
    }
}
