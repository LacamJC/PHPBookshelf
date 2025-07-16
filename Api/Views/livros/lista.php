<?php

use Api\Core\Alert;
use Api\Services\LivroService;
use Api\Widgets\Card;
use Api\Widgets\Layout;

// Carrega livros
$data = LivroService::all();

$livros = $data['livros'];
$totalPages = $data['totalPages'];
$currentPage = $data['page'];
$selfPage = isset($_GET['page']) ? $_GET['page'] : 1;


$ant = $selfPage >= 1 ? $selfPage - 1 : 1;
$next = $selfPage <= $totalPages ? $selfPage + 1 : $totalPages;


?>
<!doctype html>
<html lang="pt-BR">

<head>
    <?= Layout::head('Lista de livros') ?>
    <link rel="stylesheet" href="resources/scss/card.css">
</head>
<body>
    <?= Layout::header() ?>




    <!-- Livros -->
    <div class="container pb-5">
        <?= Alert::span() ?>
        <?php if (empty($livros)): ?>
            <div class="alert alert-info text-center" role="alert">
                Nenhum livro cadastrado ainda. Que tal adicionar o primeiro?
            </div>
        <?php else: ?>

            <div class="row">
                <?php foreach ($livros as $livro): ?>
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4 d-flex align-items-stretch">
                        <?php
                        $card = new Card;
                        $card->show($livro);
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="mx-auto w-75 text-center">
            <a href='?page=<?= $ant ?>' class='btn btn-sm btn-outline-primary $active'><i class="bi bi-arrow-left-circle"></i></a>
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                $active = $i === $currentPage ? 'active' : '';
                echo "<a href='?page=$i' class='btn btn-sm btn-primary $active'>$i</a> ";
            }
            ?>
            <a href='?page=<?= $next ?>' class='btn btn-sm btn-outline-primary $active'><i class="bi bi-arrow-right-circle"></i></a>
        </div>
    </div>

    <?= Layout::footer(); ?>
    <script src="resources/js/showPass.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body>

</html>