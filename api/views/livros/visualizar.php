<?php

use Api\Core\Alert;
use Api\Services\AvaliacaoService;
use Api\Widgets\Layout;

$capa = BASE_URL . ($livro->capa_path);
$baseUrl = BASE_URL;

$comentarios = AvaliacaoService::comentarios($livro->id);

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($livro->titulo) ?> - Detalhes do Livro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body>
    <?= Layout::header() ?>
    <div class="container my-5">
        <a href="<?= $baseUrl ?>livros" class="btn btn-secondary mb-4"><i class="bi bi-arrow-left"></i> Voltar à Lista</a>
        <?= Alert::span() ?>
        <div class="card shadow-lg">
            <div class="row g-0">
                <div class="col-md-4 text-center p-4">
                    <img src="<?= $capa ?>"
                        alt="Capa do livro"
                        class="img-fluid rounded shadow"
                        style="max-height: 400px;" />

                    <div class="mt-5">
                        <?php if ($comentarios != null): ?>
                            <h2 class="mt-5 text-secondary">Avaliações</h2>
                            <?php foreach ($comentarios as $comentario) {
                                Layout::avaliacao($comentario->nome, $comentario->nota, $comentario->comentario);
                            } ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h2 class="card-title text-primary">
                            <?= htmlspecialchars($livro->titulo) ?>
                        </h2>
                        <p class="text-muted mb-1"><i class="bi bi-person-lines-fill"></i> <strong>Autor(es):</strong> <?= htmlspecialchars($livro->autores) ?></p>
                        <p class="text-muted mb-1"><i class="bi bi-journal"></i> <strong>Editora:</strong> <?= htmlspecialchars($livro->editora) ?></p>
                        <p class="text-muted mb-1"><i class="bi bi-file-earmark-text"></i> <strong>Nº de Páginas:</strong> <?= (int)$livro->numero_paginas ?></p>
                        <p class="text-muted mb-1"><i class="bi bi-bookmark"></i> <strong>Gênero:</strong> <?= htmlspecialchars($livro->genero) ?></p>
                        <p class="text-muted mb-1"><i class="bi bi-flag"></i> <strong>Nacional:</strong> <?= $livro->nacional === 'S' ? 'Sim' : 'Não' ?></p>

                        <hr>

                        <h5 class="text-dark"><i class="bi bi-card-text"></i> Descrição</h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($livro->descricao)) ?></p>
                        <div class="mt-4">
                            <a href="<?= $baseUrl ?>livros/editar/<?= $livro->id ?>" class="btn btn-outline-primary me-2"><i class="bi bi-pencil-square"></i> Editar</a>
                            <a href="<?= $baseUrl ?>livros/delete/<?= $livro->id ?>/<?= $_ENV['EDIT_TOKEN'] ?>" class="btn btn-outline-danger"
                                onclick="return confirm('Tem certeza que deseja excluir este livro?')"><i class="bi bi-trash"></i> Excluir</a>
                        </div>
                        <!-- Área de avaliação -->
                        <hr>
                        <h4 class="mt-4">Deixe sua avaliação</h4>
                        <form method="POST" action="<?= $baseUrl ?>avaliar" class="mt-3">
                            <input type="hidden" name="edit_token" value="<?= $_ENV['EDIT_TOKEN'] ?>">
                            <input type="hidden" name="id_usuario" value="<?= $_SESSION['user']->id ?>">
                            <input type="hidden" name="id_livro" value="<?= (int)$livro->id ?>" />

                            <div class="mb-3">
                                <label for="comentario" class="form-label">Comentário</label>
                                <textarea class="form-control" id="comentario" name="comentario" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="nota" class="form-label">Nota</label>
                                <select class="form-select" id="nota" name="nota" required>
                                    <option value="" selected disabled>Selecione uma nota</option>
                                    <option value="1">1 - Péssimo</option>
                                    <option value="2">2 - Ruim</option>
                                    <option value="3">3 - Regular</option>
                                    <option value="4">4 - Bom</option>
                                    <option value="5">5 - Excelente</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary"><i class="bi bi-hand-thumbs-up"></i> Enviar Avaliação</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= Layout::footer() ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>