<?php

namespace Api\Database;

use Exception;
use PDO;

final class Connection
{
    private function __construct() {}

    public static function open($name)
    {
        if (file_exists("../config/{$name}.ini")) {
            $db = parse_ini_file("../config/{$name}.ini");
            // echo "<br>Arquivo encontrado";
        } else {
            throw new Exception("<br>Arquivo de configuração '{$name}' não encontrado");
        }

        $user = isset($db['user']) ? $db['user'] : NULL;
        $pass = isset($db['pass']) ? $db['pass'] : NULL;
        $name = isset($db['name']) ? $db['name'] : NULL;
        $host = isset($db['host']) ? $db['host'] : NULL;
        $type = isset($db['type']) ? $db['type'] : NULL;
        $port = isset($db['port']) ? $db['port'] : NULL;
        // echo "<br>" . dirname(dirname(__DIR__)) . "/$name" . "<br>";
        switch ($type) {
            case 'sqlite':
                $conn = new PDO("sqlite:". dirname(dirname(__DIR__)) . "/$name");
               
                break;

            case 'mysql':
                $port = $port ? $port : '3306';
                $conn = new PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $pass);
                break;
        }

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}
