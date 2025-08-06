<?php

require_once dirname(__DIR__, 1) . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

$name = $_ENV['CONNECTION_NAME'];
function open($name)
{
    try {
        if (file_exists(dirname(__DIR__, 1) . "/config/{$name}.ini")) {
            $db = parse_ini_file(dirname(__DIR__, 1) . "/config/{$name}.ini");
        } else {
            throw new Exception("Erro ao procurar arquivo de configurações '{$name}'");
        }
        $user = isset($db['user']) ? $db['user'] : NULL;
        $pass = isset($db['pass']) ? $db['pass'] : NULL;
        $name = isset($db['name']) ? $db['name'] : NULL;
        $host = isset($db['host']) ? $db['host'] : NULL;
        $type = isset($db['type']) ? $db['type'] : NULL;
        $port = isset($db['port']) ? $db['port'] : NULL;


        switch ($type) {
            case 'sqlite':
                $conn = new PDO("sqlite:" . dirname(__DIR__) . "/$name");

                break;

            case 'mysql':
                $port = $port ? $port : '3306';
                try {
                    $conn = new PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $pass);
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    die('Erro ao se conectar com o banco de dados');
                }
                break;
        }

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

$conn = open($name);
$migration =  require __DIR__ . '/migrations/0001-create-tables.php';

$migration($conn);
