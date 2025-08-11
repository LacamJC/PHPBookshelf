<?php

use App\Models\User;
use App\Models\ValueObjects\Password;

beforeEach(function() {
    $this->validUser = new User([
        'nome' => 'João',
        'email' => 'joao@gmail.com',
        'senha' => new Password('Aa123123')
    ]);


});

describe('UserGateway@save', function() {
    test('cria usuário com sucesso', function() {
        expect($this->gateway->save($this->validUser))
        ->toBeTrue();
    });

    test('Lança exceção ao tentar cadastrar informações duplicadas', function() {
        expect($this->gateway->save($this->validUser))
        ->toBeTrue();

        $this->expectException(PDOException::class);
        $this->gateway->save($this->validUser);
    });

    test('Lança exceção ao não receber parâmetros', function() {
        $this->expectException(ArgumentCounterror::class);
        $this->gateway->save();
    });
})->group('feature-users-arrange');