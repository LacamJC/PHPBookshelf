<?php

namespace App\Helpers\Dtos;

use App\Core\Request;
use App\Models\Livro;

class LivroDTO
{
    public function __construct(
        public readonly?int $id = null,
        public readonly ?int $id_usuario = null,
        public readonly ?string $titulo = null,
        public readonly ?string $autores = null,
        public readonly ?int $numero_paginas = null,
        public readonly ?array $genero = null,
        public readonly ?string $nacional = null,
        public readonly ?string $capa_path = null,
        public readonly ?string $editora = null,
        public readonly ?string $descricao = null,
        public readonly ?string $edit_token = null,
        public readonly ?string $capa_atual = null,
    ){}

    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('id'),
            titulo: $request->input('titulo'),
            autores: $request->input('autores'),
            numero_paginas: $request->input('numero_paginas'),
            genero: $request->input('generos'),
            descricao: $request->input('descricao'),
            nacional: $request->input('nacional'),
            capa_path: $request->file('capa_path')?->name,
            capa_atual: $request?->file('capa_atual')?->name,
            editora: $request->input('editora'),
            edit_token: $request->input('edit_token'),
            id_usuario: $request->input('id_usuario'),
        );
    }

    public function toModel(): Livro
    {
        return new Livro(get_object_vars($this));
    }
}