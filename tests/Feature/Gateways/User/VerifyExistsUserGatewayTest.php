<?php

describe('UserGateway@verifyExists', function() {
    test('Retorna true se o email exister nos registros', function() {
        $this->gateway->save($this->validUser);
        expect($this->gateway->verifyExists($this->validUser->email))
            ->toBeTrue();
    });

    test('Retorna false se não existir registros', function() {
        expect($this->gateway->verifyExists('email'))
            ->toBeFalse();
    });

    test('Lança exceção se não tiver parametros', function() {
        $this->expectException(ArgumentCountError::class);
        $this->gateway->verifyExists();
    });

})->group('feature-users-arrange');
