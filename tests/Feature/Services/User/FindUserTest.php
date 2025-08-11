<?php

use Api\Models\User;

describe('UserService@findById', function () {
    test('Buscando usuário por ID', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123123',
            'confirma' => '123123'
        ];

        $save = $this->service->save($data);
        expect($save)->toBeTrue();

        $user = $this->gateway->findByEmail($data['email']);
        expect($user)->not->toBeNull();


        $result = $this->service->findById($user->id);
        expect($result)->toBeInstanceOf(User::class);
        expect($result->email)->toBe($user->email);
    });

    test('Lança exceção por ID inválido', function () {
        $id = null;
        $this->expectException(TypeError::class);
        $this->service->findById($id);
    });

    test('Lança exceção por ID menor que 1', function () {
        $id = 0;
        $this->expectException(Exception::class);
        $this->service->findById($id);
    });
})->group('feature-users-arrange');