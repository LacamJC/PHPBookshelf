<?php

namespace App\Core;

use App\Models\ValueObjects\Password;
use InvalidArgumentException;
use stdClass;

class Request
{
    protected array $data;
    protected array $files;
    protected readonly string $method;

    public function __construct(?string $method = null, ?array $data = null, ?array $files = null)
    {
        if(is_null($method)){
            $method = $_SERVER['REQUEST_METHOD'];
        }

        if(is_null($data)){
            $data = $_POST;
        }

        $this->method = $method;
        $this->data = $data;
        $this->files = $files ?? $_FILES;
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

    public function method(): string
    {
        return $this->method;
    }

    public function file(string $name): ?stdClass
    {
        // echo "<pre>";
        // print_r($this->files);
        // print_r($this);
        if (!isset($this->files[$name])) {
            // echo $this->files[$name];
            // die($name);
            return null;
            // throw new \InvalidArgumentException("Informações sobre o arquivo '$name' não encontradas");
        }

        $fileArray = $this->files[$name];
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
    }

    protected function transfer(): void
    {
        foreach($this->data as $key => $value){
            $this->$key = $value;
        }
        unset($this->data);
    }

    protected function required(array $campos): void
    {
        foreach($campos as $campo){
            if(is_null($this->input($campo))){
                throw new \InvalidArgumentException("Campo <strong>$campo</strong> é obrigatório");
            }

            if(is_string($this->input($campo)) && strlen($this->input($campo)) == 0){
                throw new \InvalidArgumentException("O campo <strong>$campo</strong> não pode estar vazio.");
            }
        }
    }
}