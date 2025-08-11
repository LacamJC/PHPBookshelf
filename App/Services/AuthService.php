<?php

namespace App\Services;

use App\Models\User;
use PhpParser\Node\Expr\Instanceof_;

class AuthService
{
    public function persistUserSession(User $user): void
    {

        $this->logout();
        $user = $user->sanitize();

        $_SESSION['user'] = $user;
    }


    public function logout(): void
    {
        $this->clearForm();
        unset($_SESSION['user']);
    }

    public function clearForm(): void
    {
        unset($_SESSION['form_data']);
    }

    public function setForm(array|User $data): void
    {
        if (($data instanceof User)) {
            $data = [
                'id' => $data->id,
                'email' => $data->email,
                'name' => $data->nome,
                'password' => ''
            ];
        }


        $data['password'] = '';
        $_SESSION['form_data'] = $data;
    }
}
