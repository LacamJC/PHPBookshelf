<?php

namespace Api\Controllers;

use SplFileObject;

class LogController
{
    public function index()
    {
        header('Content-Type: application/json');
        $filepath = dirname(__DIR__, 2) . '/logs/app.log';
        $file = new SplFileObject($filepath);
        $lines = [];
        $max = $this->getParam('max');
        while (!$file->eof()) {
            $line = trim($file->fgets());
            if (preg_match('/^(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}) :: \[(\w+)] (.*?)(?:: (.*))?$/', $line, $matches)) {
                $lines[] = [
                    'timestamp' => $matches[1],
                    'type'      => $matches[2],
                    'origin'    => $matches[3],
                    'message'   => $matches[4] ?? null,
                ];

                if (count($lines) > $max) {
                    array_shift($lines);
                }
            }
        }
        $data = json_encode($lines);
        echo $data;
    }

    private function getParam(string $param): ?int
    {
        $param = isset($_GET[$param]) ? $_GET[$param] : 50;
        if($param < 0){
            $param = 50;
        }
        
        return (int) $param;
    }
}
