<?php

describe('UserService@delete', function () {
    test('Apagando um usuário com sucesso', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123123',
            'confirma' => '123123'
        ];

        $this->service->save($data);

        $user = $this->gateway->findByEmail($data['email']);
        expect($user)->not->toBeNull();

        $result = $this->service->delete($user->id);
        expect($result)->toBeTrue();

        $deletedUser = $this->gateway->findByEmail($data['email']);
        expect($deletedUser)->toBeNull();
    })->group('feature-users-arrange');;

    test('Lança uma exceção se o ID for inválido', function () {
        $id = null;
        $this->expectException(TypeError::class);
        $this->service->delete($id);
    });

    test('Lança uma exceção se o ID for menor que 1', function () {
        $id = 0;
        $this->expectException(Exception::class);
        $this->service->delete($id);
    });
})->group('feature-users-arrange');