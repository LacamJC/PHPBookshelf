<?php

use App\Core\Request;

beforeEach(function() {
    $this->fakeFiles = [[
    'capa_path' => [
        'name' => 'capa_livro.jpg',
        'type' => 'image/jpeg',
        'tmp_name' => '/tmp/php12345',
        'error' => 0,
        'size' => 204800,
    ]]
];

});

test('cria uma instancia com arquivos', function() {
    $file = $this->fakeFiles[0];
    $request = new Request(method: 'GET', data: [], files: $file);

    expect($request)
        ->toBeInstanceOf(Request::class);

        expect($request->file('capa_path'))
            ->toBeInstanceOf(stdClass::class)
            ->and($request->file('capa_path')->name)
                ->toBeString()
                ->toBe('capa_livro.jpg');
});

test('Se estiver vazio retorna nulo', function() {
    $request = new Request(method: 'GET', data: []);
    // $this->expectException(\InvalidArgumentException::class);
    expect($request->file('arquivo_inexistente'))
        ->toBeNull();
});