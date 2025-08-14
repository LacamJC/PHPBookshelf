<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
        <h3 class="text-center mb-4">Cadastro</h3>

        <?php $alert->span(); ?>

        <form action="usuarios" method="POST">
            <input type="hidden" name="edit_token" value="<?= $_ENV['EDIT_TOKEN'] ?>">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    value="<?= isset($old['email']) ? htmlspecialchars($old['email']) : '' ?>"
                    placeholder="Digite seu email">
            </div>

            <div class="mb-3">
                <label for="nome" class="form-label">Nome de usuário</label>
                <input
                    type="text"
                    class="form-control"
                    id="nome"
                    name="nome"
                    value="<?= isset($old['nome']) ? htmlspecialchars($old['nome']) : '' ?>"
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
                        value="<?= isset($old['senha']) ? htmlspecialchars($old['senha']) : '' ?>"
                        placeholder="Digite sua senha"
                        required
                        minlength="6"
                        maxlength="12">
                </div>
            </div>
            <div class="mb-3">
                <p class="mt-2 text-secondary small mb-1">A senha deve conter:</p>
                <ul class="text-secondary small mb-0 ps-3">
                    <li>No mínimo 6 caracteres</li>
                    <li>No máximo 12 caracteres</li>
                </ul>
            </div>
            <div class="mb-3">
                <label for="confirma" class="form-label">Confirme sua senha</label>
                <div class="input-group">
                    <input
                        type="password"
                        class="form-control"
                        id="confirm"
                        name="confirma"
                        value="<?= isset($old['confirma']) ? htmlspecialchars($old['confirma']) : '' ?>"
                        placeholder="Confirme sua senha"
                        required
                        minlength="6"
                        maxlength="12">
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

<script src="resources/js/showPass.js"></script>



