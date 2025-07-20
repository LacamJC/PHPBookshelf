<?php

class Animal
{
    private string $name;
    private array $data;
    public function __set($prop, $value)
    {
        $this->data[$prop] = $value;
    }

    public function __get($prop)
    {
        return $this->data[$prop];
    }
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function echo()
    {
        echo $this->name;
    }
}

$animal = new Animal('Cachorro');
$animal->tipo = 'Cavalo';
$novo = clone $animal;
$novo->au = 'Cachiorr';

print_r($novo);
print_r($animal);
