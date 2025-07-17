<?php

namespace Api\Core;

use Api\Abstract\Logger;

class LoggerTXT extends Logger
{

    public function write($message)
    {
        date_default_timezone_set('America/Sao_Paulo');

        $time = date("Y-m-d H:i:s");

        $text = "$time :: $message \n";

        $handler = fopen($this->filename, 'a');
        fwrite($handler, $text);
        fclose($handler);
    }

    public static function log($message, $type)
    {
        $logger = new LoggerTXT(__DIR__ . '/../../logs/app.log');
        $message = "[{$type}] " . $message;
        $logger->write($message);
    }
}
