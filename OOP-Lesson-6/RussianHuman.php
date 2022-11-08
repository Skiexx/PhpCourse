<?php

require_once 'HumanAbstract.php';

class RussianHuman extends HumanAbstract
{

    public function getGreetings(): string
    {
        return 'Привет';
    }

    public function getMyNameIs(): string
    {
        return 'Меня зовут';
    }
}