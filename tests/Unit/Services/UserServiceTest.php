<?php

use Api\Database\UserGateway;
use Api\Models\User;
use Api\Services\UserService;

beforeEach(function () {
    $this->gateway = $this->createMock(UserGateway::class);
    $this->service = new UserService($this->gateway);
});


describe('Teste para para inserção de novos usuários', function () {
    test('Cadastro de um usuário válido', function () {

        $user = new User;
        $user->nome = 'John Doe';
        $user->email = 'john.doe@gmail.com';
        $user->senha = password_hash('123123', PASSWORD_DEFAULT);

        $this->gateway->expects($this->once())
            ->method('save')
            ->with($this->callback(function ($obj) use ($user) {
                return $obj instanceof User && $obj->nome === $user->nome;
            }))
            ->willReturn(true);

        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123123',
            'confirma' => '123123'
        ];

        $result = $this->service->save($data);

        expect($result)->toBe(true);
    });
    test('Senha inválida menor que 6', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123',
            'confirma' => '123123'
        ];

        $this->gateway->expects($this->never())
            ->method('save');

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

        $this->gateway->expects($this->never())
            ->method('save');

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

        $this->gateway->expects($this->never())
            ->method('save');
        $this->expectException(InvalidArgumentException::class);
        $this->service->save($data);
    });
    test('Se ocorrer um erro ao salvar o usuário retorna uma exception', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123123',
            'confirma' => '123123'
        ];

        $user = new User;
        $user->nome = 'John Doe';
        $user->email = 'john.doe@gmail.com';
        $user->senha = password_hash('123123', PASSWORD_DEFAULT);


        $this->gateway->expects($this->once())
            ->method('save')
            ->with($this->callback(function ($obj) use ($user) {
                return $obj instanceof User && $obj->nome === $user->nome;
            }))
            ->willReturn(false);

        $this->expectException(Exception::class);
        $this->service->save($data);
    });
});

describe('Teste para remoção de um usuário', function () {
    test('Apagando um usuário com sucesso', function () {
        $id = 1;

        $this->gateway->expects($this->once())
            ->method('delete')
            ->with($id)
            ->willReturn(true);

        $result = $this->service->delete($id);

        expect($result)->toBe(true);
    });

    test('Lança uma exceção se o ID for inválido', function () {
        $id = null;

        $this->gateway->expects($this->never())
            ->method('delete');

        $this->expectException(TypeError::class);
        $this->service->delete($id);
    });

    test('Lança uma exceção se o ID for menor que 1', function () {
        $id = 0;

        $this->gateway->expects($this->never())
            ->method('delete');
        $this->expectException(Exception::class);
        $this->service->delete($id);
    });
});

describe('Testes para busca por ID', function () {
    test('Buscando usuário por ID', function () {
        $id = 1;

        $user = new User;
        $user->id = $id;

        $this->gateway->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($user);

        expect($this->service->findByid($id))->toBe($user);
    });

    test('Lança exceção por ID inválido', function () {
        $id = null;

        $this->gateway->expects($this->never())
            ->method('findById');

        $this->expectException(TypeError::class);
        $this->service->findById($id);
    });

    test('Lança exceção por ID menor que 1', function () {
        $id = 0;

        $this->gateway->expects($this->never())
            ->method('findById');

        $this->expectException(Exception::class);
        $this->service->findById($id);
    });
});

describe('Testes para verificação de credenciais', function () {
    test('Verificando informações válidas', function () {
        $email = 'john@gmail.com';
        $pass = '123123';

        $user = new user(['nome' => 'john', 'email' => $email, 'senha' => password_hash($pass, PASSWORD_DEFAULT)]);

        $this->gateway->expects($this->once())
            ->method('findByEmail')
            ->with($email)
            ->willReturn($user);

        $result = $this->service->verify($email, $pass);

        expect($result)->toBe(true);
    });

    test('Email inválido', function () {
        $email = '';
        $pass = '123123';
        $this->gateway->expects($this->never())
            ->method('findByEmail');

        $this->expectException(Exception::class);
        $this->service->verify($email, $pass);
    });
    test('Senha inválida', function () {
        $email = 'john@gmail.com';
        $pass = '';
        $this->gateway->expects($this->never())
            ->method('findByEmail');

        $this->expectException(Exception::class);
        $this->service->verify($email, $pass);
    });

    test('Lança exceção por usuário não encontrado', function () {
        $email = 'john@gmail.com';
        $pass = '123123';

        $this->gateway->expects($this->once())
            ->method('findByEmail')
            ->with($email)
            ->willReturn(null);

        $this->expectException(Exception::class);
        $this->service->verify($email, $pass);
    });

    test('Lança exceção por senhas diferentes', function () {
        $email = 'john@gmail.com';
        $pass = '123123';

        $user = new User(['nome' => 'john', 'email' => 'john@gmail.com', 'senha' => password_hash('321321', PASSWORD_DEFAULT)]);

        $this->gateway->expects($this->once())
            ->method('findByEmail')
            ->with($email)
            ->willReturn($user);

        $this->expectException(Exception::class);
        $this->service->verify($email, $pass);
    });
});

describe('Testes para atualização de usuário', function () {
    test('Atualiza informações do usuário com sucesso', function () {
        $user = new User(['id' => 1, 'nome' => 'john', 'email' => 'john@gmail.com']);
        $user_request = clone  $user;
        $user_email = clone  $user;

        $email = $user->email;



        $this->gateway->expects($this->once())
            ->method('findById')
            ->with($user->id)
            ->willReturn($user_request);

        $this->gateway->expects($this->once())
            ->method('findByEmail')
            ->with($user->email)
            ->willReturn(null);

        $this->gateway->expects($this->once())
            ->method('save')
            ->with($user)
            ->willReturn(true);

        $result = $this->service->update(['id' => 1, 'nome' => 'john', 'email' => 'john@gmail.com']);

        expect($result)->toBe(true);
    });

    test('Lança exceção por ID inválido', function () {
        $dados = [];

        $this->gateway->expects($this->never())
            ->method('findById');
        $this->gateway->expects($this->never())
            ->method('findByEmail');
        $this->gateway->expects($this->never())
            ->method('save');

        $this->expectException(InvalidArgumentException::class);
        $this->service->update($dados);
    });

    test('Usuário não pode usar um email que pertence a outro usuário', function () {
        $user = new User(['id' => 1, 'nome' => 'john', 'email' => 'john@gmail.com']);
        $user_request = clone  $user;
        $user_email = new User(['id' => 2, 'nome' => 'doe', 'email' => 'john@gmail.com']);

        $this->gateway->expects($this->once())
            ->method('findById')
            ->with($user->id)
            ->willReturn($user_request);

        $this->gateway->expects($this->once())
            ->method('findByEmail')
            ->with($user->email)
            ->willReturn($user_email);

        $this->gateway->expects($this->never())
            ->method('save');

        $this->expectException(InvalidArgumentException::class);
        $this->service->update(['id' => 1, 'nome' => 'john', 'email' => 'john@gmail.com']);
    });
});
