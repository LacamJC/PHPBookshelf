<?php

namespace App\Core;

use App\Models\ValueObjects\Password;
use InvalidArgumentException;
use stdClass;

class Request
{
    protected array $data;
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

    public function input(string $key): string | array | null{
        if(isset($this->data)){
            return $this?->data[$key];
        }
        if(isset($this->$key)){
            return $this->$key;
        }

        return null;
    }

    public function file(string $name): ?stdClass
    {
        if (!isset($_FILES[$name])) {
            return null;
        }

        $fileArray = $_FILES[$name];
        $fileObject = new stdClass();
        $fileObject->name = $fileArray['name'] ?? null;
        $fileObject->type = $fileArray['type'] ?? null;
        $fileObject->tmp_name = $fileArray['tmp_name'] ?? null;
        $fileObject->error = $fileArray['error'] ?? null;
        $fileObject->size = $fileArray['size'] ?? null;

        return $fileObject;
    }




    protected function authorize(): bool
    {
        return true;
    }

    protected function validate(): void
    {
        if (isset($this->data['email']) && !filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email inválido');
        }

        if (isset($this->data['password'])) {
            Password::allows($this->data['password']);
        }

    }

    protected function transfer()
    {
        foreach($this->data as $key => $value){
            $this->$key = $value;
        }
        unset($this->data);
    }

    protected function required(array $campos): void
    {
        foreach($campos as $campo){
            if(!isset($this->data[$campo])){
                throw new \InvalidArgumentException("Campo <strong>$campo</strong> é obrigatório");
            }

            if(is_string($this->input($campo)) && strlen($this->input($campo)) == 0){
                throw new \InvalidArgumentException("O campo <strong>$campo</strong> não pode estar vazio.");
            }
        }
    }
}