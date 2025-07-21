<?php

namespace Api\Services;

use Api\Models\User;

class AuthService
{
    public function persistUserSession(?User $user): void
    {
        $this->logout();
        $_SESSION['user'] = $user->sanitize();
    }


    public function logout(): void
    {
        unset($_SESSION['user']);
    }

    public function clearForm(): void{
        unset($_SESSION['form_data']);
    }

}
