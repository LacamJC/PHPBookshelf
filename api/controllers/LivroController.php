<?php

namespace Api\Controllers;

use Api\Middlewares\AuthMiddleware;
use Api\Core\Response;
use Api\Services\LivroService;
use Api\Services\UserService;

class LivroController
{
    public function store()
    {
        AuthMiddleware::handle();
        $dados = $_POST;
        // Validando informações do formulario
        foreach ($dados as $chave => $valor) {

            if (is_string($valor)) {
                $valor = trim($valor);
                if (strlen($valor) == 0 or $valor == '') {
                    Response::redirect('book', 'errorMessage', "O campo {$chave} não pode estar vazio");
                }
            }
            if (is_numeric($valor)) {
                if ($valor == 0 or $valor < 0) {
                    if ($chave == 'qtd_paginas') {
                        Response::redirect('book', 'errorMessage', "O numero de páginas não pode conter valores abaixo ou igual a zero");
                    } else {
                        Response::redirect('book', 'errorMessage', "O campo {$chave} não pode conter valores abaixo ou igual a zero");
                    }
                }
            }
            if ($chave == "nacional") {
                if (!in_array($valor, ['S', 'N', 's', 'n'])) {
                    Response::redirect('book', 'Selecione uma origem válida para o livro', 'danger');
                }
            }

            if (is_string($valor)) {
                $dados[$chave] = trim($valor);
            }
        }

        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";
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
            // Nenhum arquivo enviado, usa placeholder
            $dados['capa_path'] = 'public/uploads/placeholder.png';
        } else {
            // Qualquer outro erro
            Response::redirect('book', 'errorMessage', 'Erro ao salvar imagem, tente com outra');
        }

        echo "<pre>";
        print_r($dados);
        echo "</pre>";  
        // LivroService::store($dados);
    }
}
