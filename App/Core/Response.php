<?php

namespace App\Core;

class Response
{

    public static function json($data, $code = 200): never
    {

        http_response_code($code); // Define o código HTTP
        header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Content-Type: application/json"); // Garante que o retorno é JSON
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    public static function redirect(string $location, string $alertMessage = '', string $alertType = ''): never
    {
        if (strlen($alertMessage) > 0) {
            $_SESSION['alertMessage'] = $alertMessage;
            $_SESSION['alertType'] = $alertType;
        }
        header('Location: ' . '/' . $location);
        exit;
    }

    public static function view(string $templatePath, array $data = []): never
    {
        extract($data);
        $path = dirname(__DIR__, 1) . '/Views/' . $templatePath . '.php';
        if(!file_exists($path)){
            throw new \InvalidArgumentException('Arquivo "' . $path . '" não encontrado' );
        }
        include $path;
       exit;
    }
}
