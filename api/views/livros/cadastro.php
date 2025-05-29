<?php

use Api\Core\Alert;
?>

<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>

<body>

    <div class="w-50 mx-auto my-5">


        <form action="book" method="POST" enctype="multipart/form-data">
            <?php
            Alert::span();
            ?>

            <input type="hidden" name="id_usuario" value="<?= $_SESSION['user']->id ?>">

            <div class="mb-3">
                <label for="titulo" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="Percy jackson e o ladrão de raios" placeholder="Digite o titulo do livro" required>
            </div>
            <div class="mb-3">
                <label for="autores" class="form-label">autores(es)</label>
                <input type="text" class="form-control" id="autores" name="autores" value="Elisabeth swan" placeholder="Digite o nome do autores" required>
            </div>
            <div class="mb-3">
                <label for="numero_paginas" class="form-label">Quantidade de páginas</label>
                <input type="number" class="form-control" id="numero_paginas" name="numero_paginas" value="200" placeholder="Digite a quantidade de páginas" required>
            </div>
            <div class="mb-3">
                <label for="genero" class="form-label">Genero</label>
                <input type="text" class="form-control" id="genero" name="genero" value="Terror" placeholder="Digite o genero do livro" required>
            </div>
            <div class="mb-3">
                <label for="nacional">O livro é nacional ?</label>l
                <select class="form-select" aria-label="Default select example" id="nacional" name="nacional">
                    <option selected>Selecione uma opção</option>
                    <option value="S">Sim</option>
                    <option value="N">Não</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="numero_paginas" class="form-label">Editora</label>
                <input type="text" class="form-control" id="editora" name="editora" value="Burguers Book" placeholder="Digite a editora" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="capa_path">Capa do livro</label>
                <input type="file" class="form-control" name="capa_path" id="capa_path">
            </div>

            <div class="mb-3">
                <div class="form-group">
                    <label for="descricao">Descrição do livro</label>
                    <textarea class="form-control" id="descricao" rows="3" name="descricao">Descrição generica do livro</textarea>
                </div>

            </div>


            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
    </div>
    <script src="resources/js/showPass.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body>

</html>