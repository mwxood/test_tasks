<?php



class Quiz {
    private $questions = [];  

    public function __construct($questions) {
        $this->questions = $questions;
    }

    public function getQuestion($index): array {
        return $this->questions[$index] ?? null;
    }
}