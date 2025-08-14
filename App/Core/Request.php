<?php

namespace App\Core;

use App\Models\ValueObjects\Password;

class Request
{
    protected readonly array $data;
    protected readonly string $method;

    public function __construct(?string $method = null, ?array $data = null)
    {
        if(is_null($method)){
            $method = $_SERVER['REQUEST_METHOD'];
        }

        if(is_null($data)){
            $data = $_POST;
        }
        $this->method = $method;
        $this->data = $data;

        $this->validate();
    }

    public function data(): array
    {
        return $this->data;
    }

    public function input(string $key){
        $result = $this->data[$key];
        if(is_null($result)){
            throw new \InvalidArgumentException("Nenhuma inforamção sobre o campo '$key'");
        }

        return $result;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function validate(): void
    {
        if (isset($this->data['email']) && !filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email inválido');
        }

        if (isset($this->data['password'])) {
            Password::allows($this->data['password']);
        }
    }
}