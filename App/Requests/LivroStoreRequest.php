<?php

namespace App\Requests;

use App\Core\Request;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionProperty;

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

    public function __construct(?string $method = null, ?array $data = null)
    {
        parent::__construct($method, $data);
        if($this->method != 'POST'){
            throw new \DomainException('Método não suportado');
        }
        $this->transfer();
        $this->validate();
    }

    public function validate(): void
    {
    $ref = new ReflectionClass($this);
    $props = $ref->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);

    $campos = [];
    foreach ($props as $prop) {
        $prop->setAccessible(true); // garante que podemos acessar mesmo se for protegido
        if(!in_array($prop->getName(), ['id', 'nome_usuario', 'descricao', 'data']))
        {
            $campos[] = $prop->getName();
        }
    }
    if(!in_array($this->input('nacional'), ['S', 'N'])){
        throw new \InvalidArgumentException("O campo 'nacional' deve conter apenas os valores: S, N, s, n");
    }

    if(empty($this->input('generos'))){
        throw new \InvalidArgumentException('Você deve selecionar pelo menos um </strong>genêro</strong>');
    }

    if($this->input('numero_paginas') <= 0){
        throw new \InvalidArgumentException('Quantidade de <strong>páginas</strong> inválida');
    }


    $this->required($campos);
    }

}