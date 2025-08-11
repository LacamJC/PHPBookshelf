<?php

describe('UserService@update', function () {
    test('Atualiza informações do usuário com sucesso', function () {
        // Cria e salva um usuário no banco
        $data = [
            'nome' => 'John',
            'email' => 'john@gmail.com',
            'senha' => '123123',
            'confirma' => '123123'
        ];

        $this->service->save($data);

        // Busca o usuário para pegar o ID
        $user = $this->gateway->findByEmail('john@gmail.com');
        expect($user)->not->toBeNull();

        // Prepara os dados atualizados
        $updatedData = [
            'id' => $user->id,
            'nome' => 'John Atualizado',
            'email' => 'john@gmail.com', // mantido o mesmo para não dar conflito,
            'senha' => '123123'
        ];

        // Executa o update
        $result = $this->service->update($updatedData);
        expect($result)->toBeTrue();

        // Busca novamente o usuário no banco
        $updatedUser = $this->gateway->findById($user->id);
        expect($updatedUser)->not->toBeNull();
        expect($updatedUser->nome)->toBe('John Atualizado');
        expect($updatedUser->email)->toBe('john@gmail.com'); // conferência final
    });


    test('Lança exceção por dados inválido', function () {
        $dados = []; // faltando 'id'

        $this->expectException(InvalidArgumentException::class);

        $this->service->update($dados);
    });

    test('Usuário não pode usar um email que pertence a outro usuário', function () {
        // Cria o primeiro usuário
        $this->service->save([
            'nome' => 'John',
            'email' => 'john@gmail.com',
            'senha' => '123123',
            'confirma' => '123123'
        ]);

        // Cria o segundo usuário com outro e-mail
        $this->service->save([
            'nome' => 'Doe',
            'email' => 'doe@gmail.com',
            'senha' => '456456',
            'confirma' => '456456'
        ]);

        // Busca ambos para obter os IDs
        $user1 = $this->gateway->findByEmail('john@gmail.com');
        $user2 = $this->gateway->findByEmail('doe@gmail.com');

        expect($user1)->not->toBeNull();
        expect($user2)->not->toBeNull();

        // Tenta atualizar o segundo usuário usando o e-mail do primeiro
        $this->expectException(InvalidArgumentException::class);

        $this->service->update([
            'id' => $user2->id,
            'nome' => 'Doe Atualizado',
            'email' => 'john@gmail.com' // e-mail já existente de outro usuário
        ]);
    });
})->group('feature-users-arrange');