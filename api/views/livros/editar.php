<?php

use Api\Core\Alert;
use Api\Services\LivroService;
use Api\Widgets\Card;
use Api\Widgets\Layout;

$baseUrl = BASE_URL;

?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>
    <?= Layout::header() ?>

    <!-- Livros -->
    <div class="container pb-5">
        <?= Alert::span() ?>
        <div class="container my-5">
            <h1 class="mb-4">Editar Livro</h1>

            <form action="<?=$baseUrl?>livros/update" method="POST" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="id" value="<?= (int)$livro->id ?>">
                <input type="hidden" name="edit_token" value="<?=$_ENV['EDIT_TOKEN']?>">
                <input type="hidden" name="capa_atual" value="<?=$livro->capa_path?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" required
                            value="<?= htmlspecialchars($livro->titulo) ?>" placeholder="Digite o título do livro">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="autores" class="form-label">Autor(es)</label>
                        <input type="text" name="autores" id="autores" class="form-control" required
                            value="<?= htmlspecialchars($livro->autores) ?>" placeholder="Digite os autores separados por vírgula">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="numero_paginas" class="form-label">Número de páginas</label>
                        <input type="number" name="numero_paginas" id="numero_paginas" class="form-control" required min="1"
                            value="<?= (int)$livro->numero_paginas ?>" placeholder="Quantidade de páginas">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="genero" class="form-label">Gênero</label>
                        <input type="text" name="genero" id="genero" class="form-control" required
                            value="<?= htmlspecialchars($livro->genero) ?>" placeholder="Digite o gênero do livro">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nacional" class="form-label">O livro é nacional?</label>
                        <select name="nacional" id="nacional" class="form-select" required>
                            <option value="" disabled <?= ($livro->nacional !== 'S' && $livro->nacional !== 'N') ? 'selected' : '' ?>>Selecione uma opção</option>
                            <option value="S" <?= $livro->nacional === 'S' ? 'selected' : '' ?>>Sim</option>
                            <option value="N" <?= $livro->nacional === 'N' ? 'selected' : '' ?>>Não</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="editora" class="form-label">Editora</label>
                        <input type="text" name="editora" id="editora" class="form-control" required
                            value="<?= htmlspecialchars($livro->editora) ?>" placeholder="Digite a editora">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="capa_path" class="form-label">Capa do livro</label>
                        <input type="file" name="capa_path" id="capa_path" class="form-control" accept="image/*">
                        <?php if (!empty($livro->capa_path)): ?>
                            <small class="text-muted">Capa atual:</small>
                            <div class="mt-2">
                                <img src="<?=$baseUrl.htmlspecialchars($livro->capa_path) ?>" alt="Capa do livro" style="max-width: 150px;">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea name="descricao" id="descricao" class="form-control" rows="4" required
                            placeholder="Descrição do livro"><?= htmlspecialchars($livro->descricao) ?></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Salvar Alterações</button>
                <a href="<?=$baseUrl?>livros/<?=$livro->id?>" class="btn btn-secondary ms-2"><i class="bi bi-arrow-left"></i> Voltar</a>
            </form>
        </div>
    </div>
    <?= Layout::footer(); ?>
    <script src="resources/js/showPass.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body>

</html>