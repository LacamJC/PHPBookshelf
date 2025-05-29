<?php

namespace Api\Widgets;

use Api\Database\LivroGateway;

class Card
{
    public function show(LivroGateway $livro)
    {
        echo "<div class='card' style='width: 18rem;'>";
        echo "    <img src='{$livro->capa_path}' class='card-img-top' alt='Capa do livro {$livro->titulo}'>";
        echo "    <div class='card-body'>";
        echo "        <h5 class='card-title'>{$livro->titulo}</h5>";
        echo "        <p class='card-text'>{$livro->descricao}</p>";
        echo "        <a href='#' class='btn btn-primary'>Go somewhere</a>";
        echo "    </div>";
        echo "</div>";
    }
}
