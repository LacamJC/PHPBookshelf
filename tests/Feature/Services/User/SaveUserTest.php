<?php

use Api\Models\User;

describe('UserService@save', function () {
    test('Cadastro de um usuário válido', function () {
        $user = new User;
        $user->nome = 'John Doe';
        $user->email = 'john.doe@gmail.com';
        $user->senha = password_hash('123123', PASSWORD_DEFAULT);
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123123',
            'confirma' => '123123'
        ];
        $result = $this->service->save($data);
        expect($result)->toBe(true);

        $find = $this->gateway->findByEmail($user->email);
        expect($find)->toBeInstanceOf(User::class);
    });


    test('Senha inválida menor que 6', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123',
            'confirma' => '123123'
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->service->save($data);
    });

    test('Senha inválida maior que 12', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123123123123123',
            'confirma' => '123123'
        ];
        $this->expectException(InvalidArgumentException::class);
        $this->service->save($data);
    });

    test('Senha diferente de confirma senha', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123123123123123',
            'confirma' => '123123'
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->service->save($data);
    });
})->group('feature-users-arrange');