CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    senha TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)


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

CREATE TABLE IF NOT EXISTS avaliacoes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_usuario INTEGER NOT NULL,
    id_livro INTEGER NOT NULL,
    comentario TEXT,
    nota INTEGER CHECK(nota BETWEEN 1 AND 5),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_livro) REFERENCES livros(id)
)

CREATE TABLE IF NOT EXISTS likes_dislikes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_avaliacao INTEGER NOT NULL,
    id_usuario INTEGER NOT NULL,
    tipo TEXT CHECK(tipo IN ('like', 'dislike')) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_avaliacao) REFERENCES avaliacoes(id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    UNIQUE (id_avaliacao, id_usuario) 
)

