<?php

namespace App\Abstract;
use PDO;
class Gateway
{
    protected const TYPE_INT = \PDO::PARAM_INT;
    protected const TYPE_STR = \PDO::PARAM_STR;
    protected const TYPE_BOOL = \PDO::PARAM_BOOL;
}
