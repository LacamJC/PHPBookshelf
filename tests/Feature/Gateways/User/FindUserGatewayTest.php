<?php

use Api\Models\User;

describe('UserGateway@findById', function() {
    test('Encontra um usuário existente e retorna uma instância de User', function() {
        expect($this->gateway->save($this->validUser))
            ->toBeTrue();

        $user = $this->gateway->findById(1);

        expect($user)
            ->toBeInstanceOf(User::class)
            ->toHaveProperty('nome', $this->validUser->nome)
            ->toHaveProperty('email', $this->validUser->email);
    });

    test('Retorna nulo se não encontrar nenhum registro', function() {
        expect($this->gateway->findById(29323123))
            ->toBeNull();
    });

    test('Lança uma exceção se não receber parâmetros', function() {
        $this->expectException(ArgumentCountError::class);
        $this->gateway->findById();
    });
})->group('feature-users-arrange');


describe('UserGateway@findByEmail', function() {
    test('Encontra um usuário existente e retorna uma instância de User', function() {
        expect($this->gateway->save($this->validUser))
            ->toBeTrue();

        expect($this->gateway->findByEmail($this->validUser->email))
            ->toBeInstanceOf(User::class)
            ->toHaveProperty('nome', $this->validUser->nome)
            ->toHaveProperty('email', $this->validUser->email);
    });

    test('Retorna nulo se não encontrar nenhum registro', function() {
        expect($this->gateway->findByEmail(29323123))
            ->toBeNull();
    });

    test('Lança uma exceção se não receber parâmetros', function() {
        $this->expectException(ArgumentCountError::class);
        $this->gateway->findByEmail();
    });
})->group('feature-users-arrange');