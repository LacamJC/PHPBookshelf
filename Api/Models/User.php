<?php

namespace Api\Models;

class User
{
    public ?int $id;
    public ?string $nome;
    public ?string $email;
    public ?string $senha;

    public function __construct(?array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function sanitize(): self{
        $clone = clone $this;
        $clone->senha = null;

        return $clone;
    }
}
