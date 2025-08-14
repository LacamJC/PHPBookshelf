<main class="bg-light">
    <!-- Seção de boas-vindas -->
    <section class="py-5 bg-white shadow-sm mb-4">
        <?= $alert->span() ?>
        <div class="container text-center">
            <h2 class="fw-bold text-primary"><i class="bi bi-book"></i> My Bookshelf</h2>
            <p class="text-muted">O projeto My Bookshelf é uma implementação de um sistema de cadastro de livros que foi desenvolvido de ponta a ponta desde a prototipação da interface, validação do protótipo, desenvolvimento do front-end a implementação back-end.</p>

            <a href="/livros/cadastrar" class="btn btn-outline-primary btn-lg">
                Cadastre um novo livro
            </a>
        </div>
    </section>
</main>

<div class="container mt-5 pb-5">
    <!-- <?= $alert->span() ?> -->
    <?php if (empty($livros)): ?>
        <div class="alert alert-info text-center" role="alert">
            Nenhum livro cadastrado ainda. Que tal adicionar o primeiro?
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($livros as $livro): ?>
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4 d-flex align-items-stretch">
                    <?php
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


