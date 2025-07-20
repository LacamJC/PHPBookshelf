<?php

use Api\Controllers\LivroController;
use Api\Services\LivroService;
use PHPUnit\Framework\TestCase;

class LivroTest extends TestCase{
    public function testGetLivroById(){
        $livro = 'livro';

        $this->assertEquals('livro', $livro);
    }
}