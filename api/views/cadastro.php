<?php

use Api\Core\Alert;
use Api\Widgets\Layout;

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
    <?php Layout::header()?>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
            <h3 class="text-center mb-4">Cadastro</h3>

            <?php Alert::span(); ?>

            <form action="user" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        value="johndoe@gmail.com"
                        placeholder="Digite seu email"
                        required>
                </div>

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome de usuário</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nome"
                        name="nome"
                        value="John Doe"
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
                            name="password"
                            value="123456"
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
                            name="confirm"
                            value="123456"
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
    <script src="resources/js/showPass.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body>

</html>