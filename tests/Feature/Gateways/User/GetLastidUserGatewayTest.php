<?php

describe('UserGateway@getLastId', function() {
    test('Retorna o último ID da tabela de usuários', function() {
        $usuarios = $this->fiveUsersModel;
        $create = function($user) {
            $this->gateway->save($user);
        };

        array_map($create, $usuarios);

        expect($this->gateway->getLastId())
            ->toBe(5);
    });
});