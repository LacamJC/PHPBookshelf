<?php

use Api\Core\Alert;
use Api\Widgets\Layout;

$old = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : ''; 
$baseUrl = '/';
$token = $_ENV['EDIT_TOKEN'];


?>

<!doctype html>
<html lang="pt-BR">

<head>
    <?= Layout::head('Editando dados')?>
</head>

<body>
    <?php Layout::header()?>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
            <h3 class="text-center mb-4">Atualize seus dados</h3>

            <?php Alert::span(); ?>

            <form action="<?=$baseUrl?>usuarios/editSubmit/<?=$old['id']?>/<?=$token?>" method="POST">
                <input type="hidden" name="edit_token" value="<?=$_ENV['EDIT_TOKEN']?>">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        value="<?= isset($old['email']) ? htmlspecialchars($old['email']) : '' ?>"
                        placeholder="Digite seu email"
                        >
                </div>

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome de usuário</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nome"
                        name="nome"
                        value="<?= isset($old['name']) ? htmlspecialchars($old['name']) : '' ?>"
                        placeholder="Digite seu nome"
                        required>
                </div>

                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <div class="input-group">
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="senha"
                            value="<?= isset($old['password']) ? htmlspecialchars($old['password']) : '' ?>"
                            placeholder="Digite sua senha"
                            required
                            minlength="6">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="confirma" class="form-label">Confirme sua senha</label>
                    <div class="input-group">
                        <input
                            type="password"
                            class="form-control"
                            id="confirm"
                            name="confirma"
                            value="<?= isset($old['password']) ? htmlspecialchars($old['password']) : '123123' ?>"
                            placeholder="Confirme sua senha"
                            required
                            minlength="6">
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="show">
                    <label class="form-check-label" for="show">Mostrar senha</label>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <?= Layout::footer()?>
    <script src="<?=$baseUrl?>resources/js/showPass.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body>

</html>