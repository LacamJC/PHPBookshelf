<?php

namespace Api\Widgets;

class Layout
{
    public static function header()
    {
        $nome = isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']->nome) : 'Usuário';
        $id = isset($_SESSION['user']) ? (int) $_SESSION['user']->id : '';
        $baseUrl = BASE_URL;
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
                          <li class="nav-item me-3 text-secondary">
                            <div class="dropdown ">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Bem-vindo, <strong class="">{$nome}</strong>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item text-secondary" href="#"><i class="bi bi-pencil-square"></i> Editar perfil</a></li>
                                <li><a class="dropdown-item text-secondary" href="#"><i class="bi bi-shield-exclamation"></i> Alterar senha</a></li>
                                <li><a class="dropdown-item text-danger" href="{$baseUrl}usuarios/apagar-conta/{$id}/{$token}"><i class="bi bi-trash"></i> Deletar conta</a></li>
                            </ul>
                            </div>
                        </li>            
                        <li class="nav-item me-2">
                            <a class=" my-2 btn btn-outline-primary" href="{$baseUrl}livros?page=1"><i class="bi-plus-book"></i> Ver livros</a>
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
                            Bem-vindo, faça login!
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
    }

    public static function footer()
    {
        echo <<<HTML
        <footer class="text-center mt-5 mb-3 text-muted">
            <small>&copy; 2025 LacamJC - Projeto desenvolvido com o objetivo de consolidar os conhecimentos em programação orientada a objetos com <a href='https://www.php.net/' target='_BLANK'>PHP</a>.</small>
        </footer>
        HTML;
    }

    public static function head($title)
    {
        $faviconPath = 'assets/img/book.svg';
        echo <<<HTML
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>{$title}</title>
                <link rel="icon" type="image/svg+xml" href="{$faviconPath}">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
            
        HTML;
    }
}
