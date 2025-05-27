<?php

namespace Api\Controllers;

class UserController
{

    public function login()
    {
        $email  = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errorMessage'] = "Email inválido";
            header('Location: login');
            exit;
        } else {
        }
        if (strlen($password) < 6) {
            $_SESSION['errorMessage'] = "A senha deve conter ao menos 6 caracteres";
            header('Location: login');
            exit;
        }

        echo $email; 
        echo "<br>";
        echo $password;

        unset($_SESSION['errorMessage']);
    }
}
