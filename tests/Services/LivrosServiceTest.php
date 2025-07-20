<?php

use PHPUnit\Framework\TestCase;
use Api\Services\LivroService;
use Api\Database\LivroGateway;
use Api\Models\Livro;

class LivrosServiceTest extends TestCase
{
    private $gateway;
    private $service;

    protected function setUp(): void
    {
        // Mock do gateway (fingindo o comportamento, para não depender do banco)
        $this->gateway = $this->createMock(LivroGateway::class);
        $this->service = new LivroService($this->gateway);
    }

    public function testCadastroValido()
    {
        $livro = new Livro();
        $livro->titulo = 'Test Book';
        $livro->autores = 'Autor Teste';
        $livro->numero_paginas = '100';
        $livro->genero = 'Teste';
        $livro->nacional = 'S';
        $livro->capa_path = 'uploads/test.png';
        $livro->editora = 'Editora Teste';
        $livro->descricao = 'Descrição teste';

        $this->gateway->expects($this->once())
            ->method('save')
            ->willReturn(true);

        $dados = [
            'titulo' => $livro->titulo,
            'autores' => $livro->autores,
            'numero_paginas' => $livro->numero_paginas,
            'genero' => $livro->genero,
            'nacional' => $livro->nacional,
            'capa_path' => $livro->capa_path,
            'editora' => $livro->editora,
            'descricao' => $livro->descricao,
        ];

        $result = $this->service->store($dados);

        $this->assertTrue($result);
    }

    public function testCadastroInvalido()
    {
        $dados = [
            'titulo' => null,
            'autores' => 'Autor',
        ];

        $this->gateway->expects($this->never())
            ->method('save');

        $result = $this->service->store($dados);

        $this->assertFalse($result);
    }

    public function testChamandoLivroPorId()
    {
        $livro = new Livro;
        $livro->titulo = 'Test Book';
        $livro->autores = 'Autor Teste';
        $livro->numero_paginas = '100';
        $livro->genero = 'Teste';
        $livro->nacional = 'S';
        $livro->capa_path = 'uploads/test.png';
        $livro->editora = 'Editora Teste';
        $livro->descricao = 'Descrição teste';

        $id = 1;

        $this->gateway->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($livro);

        $result = $this->service->findById($id);

        $this->assertEquals($livro, $result);
        $this->assertInstanceOf(Livro::class, $result);
    }

    public function testChamandoLivrosComPaginacao()
    {
        $livro1 = new Livro;
        $livro2 = new Livro;

        $livro3 = new Livro;
        $livro4 = new Livro;


        $books = [
            $livro1,
            $livro2,
            $livro3,
            $livro4,
        ];

        $this->gateway->expects($this->once())
            ->method('countAll')
            ->willReturn(4);

        $this->gateway->expects($this->once())
            ->method('paginate')
            ->with(4, 0)
            ->willReturn($books);

        $result = $this->service->all();

        $this->assertEquals([
            'livros' => $books,
            'total' => 4,
            'page' => 1,
            'totalPages' => 1,
            'limit' => 4,
            'offset' => 0
        ], $result);
    }

    public function testDeleteBook(){
        $livro = new Livro;
        $id = 1;
        
        $livro->id = $id;

        $this->gateway->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($livro);

        $this->gateway->expects($this->once())
            ->method('delete')
            ->with($id)
            ->willReturn(true);

        $result = $this->service->delete($id);

        $this->assertTrue($result);
    }
}
