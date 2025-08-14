<?php

return function (PDO $conn) {
    $data = "INSERT INTO usuarios(id, nome, email, senha) VALUES (1, 'admin', 'admin@gmail.com', 'Aa123123'); INSERT INTO livros (id_usuario, titulo, autores, numero_paginas, genero, nacional, capa_path, editora, descricao) VALUES
(1, 'A liberdade de avançar em estado puro 1', 'Nicolas da Rocha', 200, 'Terror', 'N', 'uploads/placeholder.png', 'Record', 'Eveniet nam cumque tempora nostrum veritatis voluptatum quae porro maxime illum aut.'),
(1, 'A simplicidade de realizar seus sonhos de maneira eficaz 2', 'Valentina Castro', 967, 'Fantasia', 'N', 'uploads/placeholder.png', 'Zahar', 'Omnis aspernatur voluptatibus eveniet cum voluptates tenetur quaerat fugit tenetur animi ipsa.'),
(1, 'O direito de mudar com força total 3', 'Catarina Cardoso', 364, 'Suspense', 'N', 'uploads/placeholder.png', 'Nova Fronteira', 'Asperiores eum ipsum dicta voluptas laboriosam quam harum repellat illo.'),
(1, 'O conforto de conseguir de maneira eficaz 8', 'Dra. Stephany Dias', 331, 'Ficção Científica', 'S', 'uploads/placeholder.png', 'HarperCollins', 'Nihil dolores sequi aspernatur doloribus ex cum repellendus quam.'),
(1, 'O poder de ganhar antes de tudo 25', 'Sra. Sofia Nogueira', 847, 'Ficção Científica', 'S', 'uploads/placeholder.png', 'Arqueiro', 'Laboriosam pariatur provident explicabo magnam provident soluta excepturi non.')";


    try{
        $conn->exec($data);
        print "dados inseridos com sucesso" . PHP_EOL;
    }catch(\Exception $e){
        echo $e->getMessage();
        die();
    }
};