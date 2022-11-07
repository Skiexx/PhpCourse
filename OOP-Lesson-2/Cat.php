<?php

class Cat
{
    private $name;
    private $color;
    public $weight;

    public function __construct($name, $color)
    {
        $this->name = $name;
        $this->color = $color;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function sayMeow(): void
    {
        echo "Мяу, меня зовут $this->name и я $this->color" . PHP_EOL;
    }
}