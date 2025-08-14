<?php

use App\Core\Request;

class RequestTest extends Request
{
    public ?string $nome = null;
    public function __construct(?string $method = 'POST', ?array $data = [])
    {
        parent::__construct($method, $data);
        if($this->method != 'POST'){
            throw new \DomainException('Método não suportado');
        }
        $this->transfer();
        $this->validate();
    }
}
test('transforma os atributos dinâmicos em atributos explicitos', function() {
    $classeTeste = new RequestTest(data: ['nome' => 'joao']);
    expect($classeTeste->input('nome'))
        ->toBeString()
        ->toBe('joao');
});