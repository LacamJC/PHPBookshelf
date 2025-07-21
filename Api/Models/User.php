<?php

namespace Api\Models;

class User
{
    private ?int $id;
    private ?string $nome;
    private ?string $email;
    private ?string $senha;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
