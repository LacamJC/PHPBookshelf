<?php

use Api\Services\LivroService;
use Api\Widgets\Card;
use Api\Widgets\Layout;

// Carrega livros
$livros = LivroService::all();
?>

<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Minha Estante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="resources/scss/home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>

<body class="bg-light">

    <?= Layout::header() ?>

    <!-- Seção de boas-vindas -->
    <section class="py-5 bg-white shadow-sm mb-4">
        <div class="container text-center">
            <h2 class="fw-bold text-primary"><i class="bi bi-book"></i> My Bookshelf</h2>
            <p class="text-muted">O projeto My Bookshelf é uma implementação de um sistema de cadastro de livros que foi desenvolvido de ponta a ponta desde a prototipação da interface, validação do protótipo, desenvolvimento do front-end a implementação back-end.</p>
        </div>
    </section>

   

    <?= Layout::footer() ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>