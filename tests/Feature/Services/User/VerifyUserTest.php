<?php

use Api\Models\ValueObjects\Password;

describe('UserService@verify', function () {

    test('Permite o acesso das informações válidas', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => 'Aa123123',
            'confirma' => 'Aa123123'
        ];

        $save = $this->service->save($data);
        $password = new Password($data['senha'], true);

        expect($save)
            ->toBeTrue();


        expect($this->service->verify('john.doe@gmail.com', $password))
            ->toBeTrue();
    });

    test('Retorna uma exceção por email inválido', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123123',
            'confirma' => '123123'
        ];

        $save = $this->service->save($data);
        expect($save)->toBeTrue();

        $this->expectException(Exception::class);
        $this->service->verify('emailinvalido@gmail.cm', new Password($data['senha']));
    });
    test('Não permite o acesso com senhas diferentes do banco', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123123',
            'confirma' => '123123'
        ];

        $save = $this->service->save($data);
        expect($save)->toBeTrue();

        $this->expectException(InvalidArgumentException::class);
        $this->service->verify($data['email'], new Password('Aa123123'));
    });

    test('Lança exceção por usuário não encontrado', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123123',
            'confirma' => '123123'
        ];

        $save = $this->service->save($data);
        expect($save)->toBeTrue();

        $this->expectException(Exception::class);
        $this->service->verify('doe.john@gmail.com', new Password('Aa123123'));
    });

    test('Lança exceção por senhas diferentes', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123123',
            'confirma' => '123123'
        ];

        $save = $this->service->save($data);
        expect($save)->toBeTrue();

        $this->expectException(Exception::class);
        $this->service->verify($data['email'], new Password('412331'));
    });
})->group('feature-users-arrange');