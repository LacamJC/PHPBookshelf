<?php

use App\Core\Request;

test('Cria uma instância de Request', function() {
    $request = new Request('GET', [
        'name' => 'joao'
    ]);

    expect($request)
        ->toBeInstanceOf(Request::class)
        ->and($request->input('name'))
            ->toBe('joao')
        ->and($request->method())
            ->toBe('GET');
});