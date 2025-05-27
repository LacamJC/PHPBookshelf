<?php

// Arquivo e diretório existem? Entrega o arquivo diretamente.
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$file = __DIR__ . $path;

if (is_file($file)) {
    return false; // Deixa o servidor embutido servir o arquivo estático.
}

// Caso contrário, encaminha tudo para o index.php
require __DIR__ . '/index.php';
