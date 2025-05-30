<?php

namespace Api\Abstract;

abstract class Logger
{
    protected $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;

        // Garante que o diretório exista
        $dir = dirname($filename);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true); // cria diretórios recursivamente com permissão total
        }

        // Cria o arquivo vazio se não existir
        if (!file_exists($filename)) {
            file_put_contents($filename, '');
        }
    }

    abstract function write($message);
}
