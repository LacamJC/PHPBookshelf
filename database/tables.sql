CREATE TABLE IF NOT EXISTS usuarios (
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
    capa_path TEXT ,
    editora TEXT NOT NULL,
    descricao TEXT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
)

INSERT INTO livros VALUES()