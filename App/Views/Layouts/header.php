<?php

$nome = isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']->nome) : 'Usuário';
$id = isset($_SESSION['user']) ? (int) $_SESSION['user']->id : '';
$baseUrl = '/';
$token = $_ENV['EDIT_TOKEN'];
if (isset($_SESSION['user'])) {
    echo <<<HTML
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="{$baseUrl}home"><i class="bi bi-book"></i> My Bookshelf</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item me-2">
                            <a href="https://github.com/LacamJC/PHPBookshelf" target="_blank" class="my-2 btn btn-outline-dark"><i class="bi bi-github"></i> Github</a>
                        </li>
                        <li class="nav-item me-3 text-secondary">
                            <div class="dropdown ">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Bem-vindo, <strong class="">{$nome}</strong>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item text-secondary" href="{$baseUrl}usuarios/editar-conta/$id/$token"><i class="bi bi-pencil-square"></i> Editar perfil</a></li>
                                <li><a class="dropdown-item text-danger" href="{$baseUrl}usuarios/apagar-conta/{$id}/{$token}" onclick="return confirm('Tem certeza que deseja excluir este esta conta ? <br>Aviso: Está ação não tem volta')"><i class="bi bi-trash"></i> Deletar conta</a></li>
                            </ul>
                            </div>
                        </li>

                        <li class="nav-item me-2">
                            <a class=" my-2 btn btn-outline-primary" href="{$baseUrl}livros/cadastrar"><i class="bi-plus-circle"></i> Cadastrar Livro</a>
                        </li>
                        <li class="nav-item">
                            <a class=" my-2 btn btn-outline-danger" href="{$baseUrl}logout"><i class="bi-box-arrow-right"></i> Sair</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    HTML;
} else {
    echo <<<HTML
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="{$baseUrl}home"><i class="bi bi-book"></i> My Bookshelf</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item me-3 text-secondary">
                            Para acessar as funcionalidades do site faça
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{$baseUrl}login">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    HTML;
}