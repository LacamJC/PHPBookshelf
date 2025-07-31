<?php

use Api\Database\UserGateway;
use Api\Models\User;
use Api\Services\UserService;



beforeEach(function () {
    $pdo = new PDO('sqlite::memory:');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    senha TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)
");
    // $this->gateway = $this->createMock(UserGateway::class);
    $this->gateway = new UserGateway($pdo);
    $this->service = new UserService($this->gateway);
});



describe('UserService@save | Teste para para inserção de novos usuários', function () {
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
});


describe('UserService@delete | Teste para remoção de um usuário', function () {
    test('Apagando um usuário com sucesso', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123123',
            'confirma' => '123123'
        ];

        // Cria o usuário
        $this->service->save($data);

        // Busca o usuário salvo
        $user = $this->gateway->findByEmail($data['email']);
        expect($user)->not->toBeNull();

        // Apaga o usuário
        $result = $this->service->delete($user->id);
        expect($result)->toBeTrue();

        // Garante que o usuário foi removido
        $deletedUser = $this->gateway->findByEmail($data['email']);
        expect($deletedUser)->toBeNull();
    });



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
});

describe('UserService@findById | Testes para busca por ID', function () {
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
});

describe('UserService@findByEmail | Testes para verificação de credenciais', function () {
    test('Verificando informações válidas', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123123',
            'confirma' => '123123'
        ];

        $save = $this->service->save($data);
        expect($save)->toBeTrue();

        $result = $this->service->verify($data['email'], $data['senha']);
        expect($result)->toBe(true);
    });

    test('Email inválido', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123123',
            'confirma' => '123123'
        ];

        $save = $this->service->save($data);
        expect($save)->toBeTrue();

        $this->expectException(Exception::class);
        $this->service->verify('emailinvalido@gmail.cm', $data['senha']);
    });
    test('Senha inválida', function () {
        $data = [
            'nome' => 'John Doe',
            'email' => 'john.doe@gmail.com',
            'senha' => '123123',
            'confirma' => '123123'
        ];

        $save = $this->service->save($data);
        expect($save)->toBeTrue();

        $this->expectException(Exception::class);
        $this->service->verify($data['email'], '51243123');
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

        // $result = 
    });

    /*
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
        */
});
