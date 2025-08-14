<?php

use App\Database\AvaliacaoGateway;
use App\Database\Connection;
use App\Models\Avaliacao;
use App\Services\AvaliacaoService;

beforeEach(function() {
    $this->pdo = new PDO('sqlite::memory:');
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    senha TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS livros (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_usuario INTEGER NOT NULL,
    titulo TEXT NOT NULL,
    autores TEXT NOT NULL,
    numero_paginas INTEGER,
    genero TEXT NOT NULL,
    nacional TEXT NOT NULL CHECK(nacional IN ('S', 'N')),
    capa_path TEXT,
    editora TEXT NOT NULL,
    descricao TEXT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS avaliacoes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_usuario INTEGER NOT NULL,
    id_livro INTEGER NOT NULL,
    comentario TEXT,
    nota INTEGER CHECK(nota BETWEEN 1 AND 5),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_livro) REFERENCES livros(id)
);

");

    $conn = $this->pdo;
    // function saveBook($conn){
    //     $conn->exec("INSERT INTO livros (id_usuario, titulo, autores, numero_paginas, genero, nacional, capa_path, editora, descricao) VALUES (1, 'A liberdade de avançar em estado puro 1', 'Nicolas da Rocha', 200, 'Terror', 'N', 'uploads/placeholder.png', 'Record', 'Eveniet nam cumque tempora nostrum veritatis voluptatum quae porro maxime illum aut.');
    //     ");
    // };

    // function saveUser($conn){
    //     $conn->exec("INSERT INTO usuarios(id, nome, email, senha) VALUES(1, 'joao', 'joao@gmail.com', '123456')");
    // }

$this->gateway = new AvaliacaoGateway($this->pdo);
$this->service = new AvaliacaoService($this->gateway);
});

afterEach(function() {
    $this->pdo->exec("DELETE FROM avaliacoes;");
    $this->pdo->exec("DELETE FROM livros;");
    // $this->pdo->exec("DELETE FROM usuarios");;
});

describe('AvaliacaoService@avaliar', function() {
    test('Cria novas avaliações com sucesso', function() {
        $avaliacao = new Avaliacao(
            null,
            1,
            1,
            'muito bom',
            2,
            null
        );

        expect($this->service->avaliar($avaliacao))
            ->toBeTrue();
    });
});