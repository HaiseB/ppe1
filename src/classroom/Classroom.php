<?php

namespace Classroom;

class Classroom{

    private $id;

    private $name;

    private $number_places;

    private $computerized;

    private $locked_at;

    public function getId (): int{
        return $this->id;
    }

    public function getName (): string{
        return $this->name;
    }

    public function getNumber_places (): int{
        return $this->number_places;
    }

    public function getComputerized (): bool{
        return $this->computerized;
    }

    public function getLocked_at (): \Datetime{
        return new \Datetime($this->locked_at);
    }

    public function setName (string $name){
        $this->name = $name;
    }

    public function setNumber_places (int $number_places){
        $this->number_places = $number_places;
    }

    public function setComputerized (bool $computerized){
        $this->computerized = $computerized;
    }

    public function setLocked_at (string $locked_at){
        $this->locked_at = $locked_at;
    }
}

?>