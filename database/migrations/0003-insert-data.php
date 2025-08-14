<?php

return function (PDO $conn) {
    $data = "INSERT INTO usuarios(id, nome, email, senha) VALUES (1, 'admin', 'admin@gmail.com', 'Aa123123');  INSERT INTO livros (id_usuario, titulo, autores, numero_paginas, genero, nacional, capa_path, editora, descricao) VALUES
(1, 'Aprendendo php com programação orientada a objetos', 'Pablo Deglaglio', 350, 'Educação', 'N', 'uploads/aprendendo-php-com-programacao-orientada-a-objetos.jpeg', 'Não informado', 'Livro para aprender PHP com foco em programação orientada a objetos.'),
(1, 'Aprendendo node', 'Oreily', 280, 'Educação', 'N', 'uploads/aprendendo-node.jpg', 'Oreily', 'Introdução ao desenvolvimento com Node.js.'),
(1, 'Aprendendo php', 'Oreily', 300, 'Educação', 'N', 'uploads/aprendendo-php.jpg', 'Oreily', 'Aprenda PHP do básico ao avançado.'),
(1, 'Entendendo algoritmos', 'Não sei', 200, 'Educação', 'N', 'uploads/entendendo-algoritmos.jpg', 'Não informado', 'Conceitos fundamentais de algoritmos e lógica de programação.')";
    try{
        $conn->exec($data);
        print "dados inseridos com sucesso" . PHP_EOL;
    }catch(\Exception $e){
        echo $e->getMessage();
        die();
    }
};