<div class="container pb-5">
    <?= $alert->span() ?>
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

