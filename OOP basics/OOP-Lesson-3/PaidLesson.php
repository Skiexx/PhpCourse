<?php

require_once 'Lesson.php';

class PaidLesson extends Lesson
{
    private $price;

    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function __construct(string $title, string $text, string $homework, string $price)
    {
        parent::__construct($title, $text, $homework);
        $this->price = $price;
    }
}