<?php

use App\Core\Request;

class RequestTest2 extends Request
{
    public ?string $nome = null;
    public function __construct(?string $method = 'POST', ?array $data = [])
    {
        parent::__construct($method, $data);
        if($this->method != 'POST'){
            throw new \DomainException('Método não suportado');
        }
        $this->required([
            'nome',
            'idade'
        ]);
    }
}
test('valida com sucesso campos com regras', function() {
    $request = new RequestTest2(method: 'POST', data: [
        'nome' => 'Nome válido',
        'idade' => 'idade valida'
    ]);

    expect($request)
        ->toBeInstanceOf(RequestTest2::class);

});

test('lança exceção se os campos não forem válido', function() {
    $this->expectException(\InvalidArgumentException::class);
    $request = new RequestTest2(method: 'POST', data: [
        'nome' => '',
        'idade' => null
    ]);

});