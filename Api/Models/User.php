<?php

namespace Api\Models;

class User
{
    public ?int $id = null;
    public ?string $nome = null;
    public ?string $email = null;
    public ?string $senha = null;

    public function __construct(?array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function sanitize(): self
    {
        $clone = clone $this;
        $clone->senha = null;

        return $clone;
    }
}
