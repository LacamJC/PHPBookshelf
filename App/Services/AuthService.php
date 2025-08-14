<?php

namespace App\Services;

use App\Core\Request;
use App\Models\User;
use PhpParser\Node\Expr\Instanceof_;
use stdClass;

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

    public function setForm(Request|User|array $request): void
    {
        // echo "<pre>";

        // print_R($request);
        // die();
        if($request instanceof Request){

            $data = [
                // 'id' => $request->input('id') ?? ''??,
                'email' => $request->input('email'),
                // 'name' => $request->input('name'),
                'password' => ''
            ];
        }


        $data['password'] = '';
        $_SESSION['form_data'] = $data;
    }

    public static function getUser(): User
    {
        return ($_SESSION['user']);
    }
}
