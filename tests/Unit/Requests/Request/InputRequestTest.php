<?php

use App\Core\Request;

test('deve chamar os valores de uma request receber seus valores e tipos corretos', function() {
    $request = new Request('GET', [
        'name' => 'joao',
        'senha' => '123456',
    ]);

    expect($request)
        ->toBeInstanceOf(Request::class)
        ->and($request->input('name'))
            ->toBeString()
            ->toBe('joao')
        ->and($request->input('senha'))
            ->toBeString()
            ->toBe('123456');
});

test('deve retornar os arrays recebidos ao serem chamados', function(){
        $request = new Request('GET', [
        'frutas' => ['maca', 'pera', 'amora'],
        'pessoas' => ['joao', 'pedro', 'maria'],
    ]);

    expect($request)
        ->toBeInstanceOf(Request::class)
        ->and($request->input('frutas'))
            ->toBeArray()
            ->toContain('maca', 'pera', 'amora')
        ->and($request->input('pessoas'))
            ->toBeArray()
            ->toContain('joao', 'pedro', 'maria');
});

test('deve retornar nulo se não existir o campo chamado', function() {
    $request= new Request('GET', ['nome' => 'joao']);

    expect($request->input('sobrenome'))
        ->toBeNull();
});