<?php

namespace Api\Models\ValueObjects;

use InvalidArgumentException;

class Password
{
    private string $password;

    public function __construct(string $password, bool $alreadyHashed  = false){
        if(!$alreadyHashed){
            $this->validate($password);
            $password = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->password = $password;
    }

    public function value(): string
    {
        return $this->password;
    }

    public function verify(string $passwordReceive): bool
    {
        return password_verify($passwordReceive, $this->password);
    }

    private function validate(string $password): void
    {
        if(strlen($password) < 6){
            throw new InvalidArgumentException('A senha deve conter ao menos 6 caracteres');
        }

        if(strlen($password) > 12){
            throw new InvalidArgumentException('A senha não pode conter mais que 12 caracteres');
        }

        if(!preg_match('/[A-Z]/', $password)){
            throw new InvalidArgumentException('A senha deve conter ao menos uma letra maiúscula');
        }

        if(!preg_match('/[a-z]/', $password)){
            throw new InvalidArgumentException('A senha deve conter ao menos uma letra minúscula');
        }
    }
}