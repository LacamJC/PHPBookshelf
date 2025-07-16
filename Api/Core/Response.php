<?php

namespace Api\Core;

class Response
{
    public static function json($data, $code = 200)
    {
        http_response_code($code); // Define o código HTTP
        header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Content-Type: application/json"); // Garante que o retorno é JSON
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public static function redirect($location, $alertMessage = '', $alertType = '')
    {
        if (strlen($alertMessage) > 0) {
            $_SESSION['alertMessage'] = $alertMessage;
            $_SESSION['alertType'] = $alertType;
        }
        header('Location: ' . '/' . $location);
        exit;
    }
}
