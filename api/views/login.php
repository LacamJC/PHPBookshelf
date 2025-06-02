<?php

use Api\Core\Alert;
use Api\Widgets\Layout;
$old = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : '';

?>

<!doctype html>
<html lang="pt-BR">

<?= Layout::head('Faça login') ?>

<body>
    <?= Layout::header() ?>

    <div class="container d-flex justify-content-center align-items-center my-5">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-4">Login</h3>

            <?php Alert::span(); ?>

            <form action="login" method="POST">
                <input type="hidden" name="edit_token" value="<?=$_ENV['EDIT_TOKEN']?>">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        value="<?=isset($old['email']) ? $old['email'] : '' ?>"
                        placeholder="Digite seu email"
                        required
                        >
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <div class="input-group">
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            value="<?=isset($old['password']) ? $old['password'] : '' ?>"
                            placeholder="Digite sua senha"
                            required
                            minlength="6">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="show">
                        <label class="form-check-label" for="show">Mostrar senha</label>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                    <a href="<?=BASE_URL?>cadastro" class="btn btn-outline-secondary">Faça seu cadastro</a>
                </div>
            </form>
        </div>
    </div>

    <?= Layout::footer() ?>
    <script src="resources/js/showPass.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body>

</html>