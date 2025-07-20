<?php

namespace Api\Widgets;

use Api\Database\LivroGateway;
use Api\Models\Livro;

class Card
{
    public function show(Livro $livro)
    {
        $id = $livro->id;
        $titulo = htmlspecialchars($livro->titulo);
        $descricao = htmlspecialchars($livro->descricao);
        $categoria = htmlspecialchars($livro->genero);
        $capa = htmlspecialchars($livro->capa_path ?? 'assets/img/placeholder.png');
        $baseUrl = '/';
        echo <<<HTML
        <div class="card h-100 shadow-sm livro_card">
            <img src="{$capa}" class="card-img-top" alt="Capa do livro {$titulo}" style="height: 250px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title text-truncate" title="{$titulo}">{$titulo}</h5>
                <h6 class="text-secondary">Genero: {$categoria}</h6>
                <p class="card-text text-muted" style="max-height: 4.5em; overflow: hidden; text-overflow: ellipsis;">
                    {$descricao}
                </p>
                <a href="{$baseUrl}livros/{$id}" class="btn btn-outline-primary mt-auto"><i class="bi-eye"></i> Visualizar</a>
            </div>
        </div>
        HTML;
    }
}
