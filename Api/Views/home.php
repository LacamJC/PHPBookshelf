<?php

use Api\Core\Alert;
use Api\Services\LivroService;
use Api\Widgets\Card;
use Api\Widgets\Layout;

// Carrega livros
$livros = LivroService::all();
?>

<!doctype html>
<html lang="pt-BR">

<head>
    <?= Layout::head('Bem vindo') ?>

</head>

<body class="bg-light">

    <?= Layout::header() ?>

    <!-- Seção de boas-vindas -->
    <section class="py-5 bg-white shadow-sm mb-4">
        <?= Alert::span() ?>
        <div class="container text-center">
            <h2 class="fw-bold text-primary"><i class="bi bi-book"></i> My Bookshelf</h2>
            <p class="text-muted">O projeto My Bookshelf é uma implementação de um sistema de cadastro de livros que foi desenvolvido de ponta a ponta desde a prototipação da interface, validação do protótipo, desenvolvimento do front-end a implementação back-end.</p>

            <a href="/livros" class="btn btn-outline-primary btn-lg">
                Ver Livros
            </a>
        </div>
    </section>



    <?= Layout::footer() ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>