<?php

namespace App\Helpers\Dtos;

use App\Models\Avaliacao;
use stdClass;

class AvaliacaoDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $id_usuario,
        public readonly ?int $id_livro,
        public readonly ?string $comentario,
        public readonly ?string $nota,
        public readonly ?string $created_at,
    )
    {
    }

    public function toModel(): Avaliacao
    {
        return new Avaliacao(
            id: $this->id,
            id_usuario: $this->id_usuario,
            id_livro: $this->id_livro,
            comentario: $this->comentario,
            nota: $this->nota,
            created_at: $this->created_at
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            id_usuario: $data['id_usuario'],
            id_livro: $data['id_livro'],
            comentario: $data['comentario'],
            nota: $data['nota'],
            created_at: $data['created_at'] ?? null
        );
    }

    public static function fromObj(stdClass $obj): self
    {
        return new self(
            id: $obj->id ?? null,
            id_usuario: $obj->id_usuario,
            id_livro: $obj->id_livro,
            comentario: $obj->comentario,
            nota: $obj->nota,
            created_at: $obj->created_at ?? null
        );
    }
}