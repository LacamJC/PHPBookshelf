<?php

namespace App\Models;

use InvalidArgumentException;

class Avaliacao
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $id_usuario,
        public readonly ?int $id_livro,
        public readonly ?string $comentario,
        public readonly ?string $nota,
        public readonly ?string $created_at,
    )
    {}

    public function setId($id)
    {
        $this->id = $id;
    }
}