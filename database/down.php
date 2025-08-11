<?php

require_once __DIR__ . '/config.php';

$conn = open($name);
$migration =  require __DIR__ . '/migrations/0002-down-tables.php';

$migration($conn);
