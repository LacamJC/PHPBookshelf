<?php

namespace Api\Widgets;

class Layout
{
    public static function header()
    {
        $nome = isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']->nome) : 'Usuário';

        if (isset($_SESSION['user'])) {
            echo <<<HTML
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="#">📚 My Bookshelf</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item me-3 text-secondary">
                            Bem-vindo, <strong class="text-dark">{$nome}</strong>
                        </li>
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-primary" href="book">+ Cadastrar Livro</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-danger" href="logout">Sair</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        HTML;
        } else {
            echo <<<HTML
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm mb-4">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="#">📚 My Bookshelf</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item me-3 text-secondary">
                            Bem-vindo, faça login!
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="login">Login</a>
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
            <small>&copy; 2025 My Bookshelf. Todos os direitos reservados.</small>
        </footer>
        HTML;
    }
}
