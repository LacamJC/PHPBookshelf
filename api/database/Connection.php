<?php

namespace Api\Database;

use Api\Core\LoggerTXT;
use Api\Core\Response;
use Exception;
use PDO;
use PDOException;

final class Connection
{
    private function __construct() {}

    public static function open($name)
    {
        try {


            if (file_exists("../config/{$name}.ini")) {
                $db = parse_ini_file("../config/{$name}.ini");
            } else {
                throw new Exception("Erro ao procurar arquivo de configurações '{$name}'");
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
                    $conn = new PDO("sqlite:" . dirname(dirname(__DIR__)) . "/$name");

                    break;

                case 'mysql':
                    $port = $port ? $port : '3306';
                    try {
                        $conn = new PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $pass);
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    break;
            }

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         
            return $conn;
        } catch (Exception $e) {
            LoggerTXT::log('Connection@open: ' . $e->getMessage(), 'Error');
            Response::redirect('', 'Desculpe no momento estamos com problemas no servidor', 'danger');
        }
    }
}
