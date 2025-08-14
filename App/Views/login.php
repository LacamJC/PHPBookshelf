
<div class="container d-flex justify-content-center align-items-center my-5">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Login</h3>
            <?= $alert->span() ?>
        <form action="login" method="POST">
            <input type="hidden" name="edit_token" value="<?= $_ENV['EDIT_TOKEN'] ?>">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    value="<?= isset($old['email']) ? $old['email'] : '' ?>"
                    placeholder="Digite seu email"
                    required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <div class="input-group">
                    <input
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        value="<?= isset($old['password']) ? $old['password'] : '' ?>"
                        placeholder="Digite sua senha"
                        required
                        minlength="6"
                        maxlength="12">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="show">
                    <label class="form-check-label" for="show">Mostrar senha</label>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Entrar</button>
                <a href="/cadastro" class="btn btn-outline-secondary">Faça seu cadastro</a>
                <hr>
                <a href="https://github.com/LacamJC/PHPBookshelf" target="_blank" class="btn btn-outline-dark d-flex justify-content-center align-items-center gap-2">
                    <i class="bi bi-github fs-4">
                    </i>Documentação</a>
            </div>
        </form>
    </div>
</div>

<script src="resources/js/showPass.js"></script>

