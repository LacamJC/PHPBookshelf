<?php

use Api\Core\Alert;
use Api\Widgets\Layout;

?>

<!doctype html>
<html lang="pt-BR">

<head>
    <?= Layout::head('Cadastro de livros') ?>

</head>

<body>
    <?= Layout::header() ?>
    <div class="container-sm mx-auto my-5">

        <form action="/livros" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow-sm">
            <?php Alert::span(); ?>

            <input type="hidden" name="id_usuario" value="<?= $_SESSION['user']->id ?>">

            <h4 class="mb-4 text-primary"><i class="bi bi-book"></i> Cadastrar Novo Livro</h4>

            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="Percy Jackson e o Ladrão de Raios" placeholder="Digite o título do livro" required>
            </div>

            <div class="mb-3">
                <label for="autores" class="form-label">Autor(es)</label>
                <input type="text" class="form-control" id="autores" name="autores" value="Elisabeth Swan" placeholder="Digite o nome do(s) autor(es)" required>
            </div>
            <p class="text-secondary">Caso o livro tenha mais de um autor, separe por ';'</p>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="numero_paginas" class="form-label">Número de páginas</label>
                    <input type="number" class="form-control" id="numero_paginas" name="numero_paginas" value="200" placeholder="Quantidade de páginas" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="genero" class="form-label">Gênero</label>
                    <input type="text" class="form-control" id="genero" name="genero" value="Terror" placeholder="Ex: Fantasia, Romance..." required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nacional" class="form-label">O livro é nacional?</label>
                    <select class="form-select" id="nacional" name="nacional" required>
                        <option value="D" disabled selected>Selecione uma opção</option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="editora" class="form-label">Editora</label>
                    <input type="text" class="form-control" id="editora" name="editora" value="Burguers Book" placeholder="Nome da editora" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="capa_path" class="form-label">Capa do livro</label>
                <input type="file" class="form-control" name="capa_path" id="capa_path">
            </div>

            <div class="mb-4">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" rows="4" name="descricao" placeholder="Fale um pouco sobre o livro">Descrição genérica do livro</textarea>
            </div>

            <button type="submit" class="btn btn-success"><i class="bi bi-book"></i> Cadastrar Livro</button>
        </form>
    </div>
    <?= Layout::footer(); ?>
    <script src="resources/js/showPass.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body>

</html>