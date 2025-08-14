<?php

require_once __DIR__ . '/config.php';

$conn = open($name);
$migration =  require __DIR__ . '/migrations/0001-create-tables.php';

$migration($conn);

$seed = require __DIR__ . '/migrations/0003-insert-data.php';

$seed($conn);
