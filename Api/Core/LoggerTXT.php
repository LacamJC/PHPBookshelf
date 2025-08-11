<?php

namespace Api\Core;

use Api\Abstract\Logger;

class LoggerTXT extends Logger
{

    public function write($message)
    {
        date_default_timezone_set('America/Sao_Paulo');

        $time = date("Y-m-d H:i:s");

        $text = "$time :: $message" . PHP_EOL;

            $handler = fopen($this->filename, 'a');
            fwrite($handler, $text);
            fclose($handler);
    }

    public static function log($message, $type, $logger = null)
    {
        $env = $_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? 'production';
        if($env == 'testing'){
            return;
        }

        $message = "[{$type}] " . $message;
        $logger = new LoggerTXT(__DIR__ . '/../../logs/app.log');
        $logger->write($message);
    }
}
