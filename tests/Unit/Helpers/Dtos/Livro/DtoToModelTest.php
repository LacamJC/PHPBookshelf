<?php

use App\Core\Request;
use App\Helpers\Dtos\LivroDTO;
use App\Requests\LivroStoreRequest;

$validRequests = [
    new LivroStoreRequest(method: 'POST', data: [
        'id_usuario' => 1,
        'titulo' => 'O Poder do Hábito',
        'autores' => 'Charles Duhigg',
        'numero_paginas' => 408,
        'generos' => ['Autoajuda', 'Psicologia'],
        'nacional' => 'S',
        'editora' => 'Objetiva',
        'edit_token' => 'token1'
    ]),

    new LivroStoreRequest(method: 'POST', data: [
        'id_usuario' => 2,
        'titulo' => '1984',
        'autores' => 'George Orwell',
        'numero_paginas' => 328,
        'generos' => ['Ficção', 'Distopia'],
        'nacional' => 'N',
        'editora' => 'Companhia das Letras',
        'edit_token' => 'token2'
    ]),

    new LivroStoreRequest(method: 'POST', data: [
        'id_usuario' => 00,
        'titulo' => 'O Senhor dos Anéis',
        'autores' => 'J.R.R. Tolkien',
        'numero_paginas' => 1178,
        'generos' => ['Fantasia', 'Aventura'],
        'nacional' => 'N',
        'editora' => 'HarperCollins',
        'edit_token' => 'token3'
    ]),

    new LivroStoreRequest(method: 'POST', data: [
        'id_usuario' => 4,
        'titulo' => 'A Menina que Roubava Livros',
        'autores' => 'Markus Zusak',
        'numero_paginas' => 552,
        'generos' => ['Ficção', 'Histórico'],
        'nacional' => 'N',
        'editora' => 'Intrínseca',
        'edit_token' => 'token4'
    ]),

    new LivroStoreRequest(method: 'POST', data: [
        'id_usuario' => 5,
        'titulo' => 'Harry Potter e a Pedra Filosofal',
        'autores' => 'J.K. Rowling',
        'numero_paginas' => 320,
        'generos' => ['Fantasia', 'Aventura'],
        'nacional' => 'N',
        'editora' => 'Rocco',
        'edit_token' => 'token5'
    ]),
];

test('Cria uma instância vazia corretamente', function() {
    expect(new LivroDTO())
        ->toBeInstanceOf(LivroDTO::class);
});

test('Cria um objeto DTO a partir de uma classe request', function($request) {
    $request = new LivroStoreRequest(method: 'POST', data: [
        'id_usuario' => 1,
        'titulo' => 'Titulo do livro',
        'autores' => 'jonny blaze',
        'numero_paginas' => 200,
        'generos' => ['Ação', 'Aventura'],
        'nacional' => 'S',
        'editora' => 'Do rock',
        'edit_token' => 'okaosdkaokdkakdwokoawdokaokok'
    ]);

    $dto = LivroDTO::fromRequest($request);

    expect($dto)
        ->toBeInstanceOf(LivroDTO::class);
})->with($validRequests);