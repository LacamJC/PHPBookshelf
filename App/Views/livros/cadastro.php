<div class="container-sm mx-auto my-5">

    <form action="/livros" method="POST" enctype="multipart/form-data" class="p-4 bg-white rounded shadow-sm">
        <?php $alert->span(); ?>

        <input type="hidden" name="id_usuario" value="<?= $_SESSION['user']->id ?>">

        <h4 class="mb-4 text-primary"><i class="bi bi-book"></i> Cadastrar Novo Livro</h4>

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="" placeholder="Digite o título do livro" required>
        </div>

        <div class="mb-3">
            <label for="autores" class="form-label">Autor(es)</label>
            <input type="text" class="form-control" id="autores" name="autores" value="" placeholder="Digite o nome do(s) autor(es)" required>
        </div>
        <p class="text-secondary">Caso o livro tenha mais de um autor, separe por ';'</p>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="numero_paginas" class="form-label">Número de páginas</label>
                <input type="number" class="form-control" id="numero_paginas" name="numero_paginas" value="" placeholder="Quantidade de páginas" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="genero" class="form-label">Gênero</label>
                <input type="text" class="form-control" id="genero" name="genero" value="" placeholder="Ex: Fantasia, Romance..." required>
            </div>
        </div>

        <div class="row">
            <!-- <div class="col-md-6 mb-3">
                <label for="nacional" class="form-label">O livro é nacional?</label>
                <select class="form-select" id="nacional" name="nacional" required>
                    <option value="D" disabled selected>Selecione uma opção</option>
                    <option value="S">Sim</option>
                    <option value="N">Não</option>
                </select>
            </div> -->

            <div class="col-md-6 mb-3">
                 <label for="nacional" class="form-label">O livro é nacional?</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="nacional" id="nacionalSim" value="S">
                    <label class="form-check-label" for="nacionalSim">
                        Sim
                    </label>
                </div>
                 <div class="form-check">
                    <input class="form-check-input" type="radio" name="nacional" id="nacionalNao" value="N">
                    <label class="form-check-label" for="nacionalNao">
                        Não
                    </label>
                </div>
            </div>


            <div class="col-md-6 mb-3">
                <label for="editora" class="form-label">Editora</label>
                <input type="text" class="form-control" id="editora" name="editora" value="" placeholder="Nome da editora" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="capa_path" class="form-label">Capa do livro</label>
            <input type="file" class="form-control" name="capa_path" id="capa_path">
        </div>

        <div class="mb-4">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" rows="4" name="descricao" placeholder="Fale um pouco sobre o livro">Descrição genérica do livro</textarea>
        </div>

        <button type="submit" class="btn btn-success"><i class="bi bi-book"></i> Cadastrar Livro</button>
    </form>
</div>

<script src="resources/js/showPass.js"></script>
