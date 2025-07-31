<?php

return function (PDO $conn) {
    $tables = [
        "
    CREATE TABLE IF NOT EXISTS usuarios (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nome VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )
    ",
        "
    CREATE TABLE IF NOT EXISTS livros (
        id INT PRIMARY KEY AUTO_INCREMENT,
        id_usuario INT NOT NULL,
        titulo VARCHAR(255) NOT NULL,
        autores VARCHAR(255) NOT NULL,
        numero_paginas INT,
        genero VARCHAR(100) NOT NULL,
        nacional ENUM('S', 'N') NOT NULL, 
        capa_path VARCHAR(255),
        editora VARCHAR(255) NOT NULL,
        descricao TEXT NOT NULL,
        FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
    )
    ",
        "
    CREATE TABLE IF NOT EXISTS avaliacoes (
        id INT PRIMARY KEY AUTO_INCREMENT,
        id_usuario INT NOT NULL,
        id_livro INT NOT NULL,
        comentario TEXT,
        nota INT CHECK(nota BETWEEN 1 AND 5),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
        FOREIGN KEY (id_livro) REFERENCES livros(id) ON DELETE CASCADE
    )
    ",
        "
    CREATE TABLE IF NOT EXISTS likes_dislikes (
        id INT PRIMARY KEY AUTO_INCREMENT,
        id_avaliacao INT NOT NULL,
        id_usuario INT NOT NULL,
        tipo ENUM('like', 'dislike') NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_avaliacao) REFERENCES avaliacoes(id) ON DELETE CASCADE,
        FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
        UNIQUE (id_avaliacao, id_usuario)
    )
    "
    ];


    try {
        foreach ($tables as $table) {
            $conn->exec($table);
        }
        print "tabelas criadas com sucesso" . PHP_EOL;
    } catch (\Exception $e) {
        echo $e->getMessage();
        exit(1);
    }
};
