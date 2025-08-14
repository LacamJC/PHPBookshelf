<?php

namespace App\Requests;

use App\Core\Request;
use InvalidArgumentException;

class LivroStoreRequest extends Request
{
    protected ?string $id = null;
    protected string $id_usuario;
    protected string $titulo;
    protected string $autores;
    protected int $numero_paginas;
    protected array $generos;
    protected string $nacional;
    // protected string $capa;

    protected string $editora;
    protected string $descricao;
    protected string $edit_token;

    public function __construct()
    {
        parent::__construct();
        if($this->method != 'POST'){
            throw new \DomainException('Método não suportado');
        }
        $this->transfer();
    }

    public function validate(): void
    {
        $campos = array_keys(get_object_vars($this)['data']);
        // var_dump($campos);
        // die();
        $this->required($campos);
    }

}