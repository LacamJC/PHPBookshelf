<?php

use Api\Database\LivroGateway;
use Api\Models\Livro;
use Api\Services\LivroService;

beforeEach(function () {
    $this->gateway = $this->createMock(LivroGateway::class);
    $this->service = new LivroService($this->gateway);
});

test('Cadastro de um livro com informações válidas', function () {
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
        ->with($this->callback(function ($obj) use ($livro) {
            return $obj instanceof Livro && $obj->titulo === $livro->titulo;
        }))
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

    expect($result)->toBe(true);
});

test('Não permite o cadastro de livro com informações vazias', function () {
    $dados = [
        'titulo' => null,
        'autores' => 'Autor',
    ];

    $this->gateway->expects($this->never())
        ->method('save');

    $result = $this->service->store($dados);

    expect($result)->toBe(false);
});

test('Busca livro por ID válido', function () {
    $id = (int) 1;

    $livro = new Livro;
    $livro->titulo = 'Test Book';
    $livro->autores = 'Autor Teste';
    $livro->numero_paginas = '100';
    $livro->genero = 'Teste';
    $livro->nacional = 'S';
    $livro->capa_path = 'uploads/test.png';
    $livro->editora = 'Editora Teste';
    $livro->descricao = 'Descrição teste';
    $livro->id = $id;

    $this->gateway->expects($this->once())
        ->method('findById')
        ->with($id)
        ->willReturn($livro);

    $result = $this->service->findById($id);

    expect($result)->toBe($livro);
    expect($result)->toBeInstanceOf(Livro::class);
    expect($result->id)->toBe(1);
});

test('Lança uma exceção se não encontrar nenhum registro', function () {

    $id = 900;
    $this->gateway->expects($this->once())
        ->method('findById')
        ->with($id)
        ->willReturn(null);

    $this->expectException(\Exception::class);
    $this->service->findById($id);
});


test('Busca de livros com paginação', function () {
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

    expect($result)->toBe([
        'livros' => $books,
        'total' => 4,
        'page' => 1,
        'totalPages' => 1,
        'limit' => 4,
        'offset' => 0
    ]);
});

test('Não permite a busca de páginas inexistentes, onde o indice de busca é menor que 1', function () {
    $this->expectException(\Exception::class);
    $this->service->all(-1);
});

test('Não permite a busca de paginação inexistentes, maiores que o total de páginas', function () {
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

    $this->gateway->expects($this->never())
        ->method('paginate');

    $this->expectException(\Exception::class);
    $this->service->all(10);
});

test('Apaga um registro do banco de dados', function () {
    $livro = new Livro();
    $livro->capa_path = 'uploads/placeholder.png';
    $livro->id = 1;
    $this->gateway->expects($this->once())
        ->method('findById')
        ->with($livro->id)
        ->willReturn($livro);

    $this->gateway->expects($this->once())
        ->method('delete')
        ->with($livro->id)
        ->willReturn(true);

    $result = $this->service->delete($livro->id);

    expect($result)->toBe(true);
});

test('Lança uma exceção se o livro  não for encontrado ao tentar deletar', function(){

    $this->gateway->expects($this->once())
        ->method('findById')
        ->with(1)
        ->willReturn(null);
    
    $this->gateway->expects($this->never())
        ->method('delete');
    
    $this->expectException(\Exception::class);
    $this->service->delete(1);
});
