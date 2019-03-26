<?php

namespace Calendar;

class Event{

    private $id;

    private $name;

    private $description;

    private $start;

    private $end;

    private $id_league;

    private $id_classroom;

    public function getId (): int{
        return $this->id;
    }

    public function getName (): string{
        return $this->name;
    }

    public function getDescription (): string{
        return $this->description ?? '';
    }

    public function getStart (): \Datetime{
        return new \Datetime($this->start);
    }

    public function getEnd (): \Datetime{
        return new \Datetime($this->end);
    }

    public function getId_league (): int{
        return $this->id_league;
    }

    public function getId_classroom (): int{
        return $this->id_classroom;
    }

    public function setName (string $name){
        $this->name = $name;
    }

    public function setDescription (string $description){
        $this->description = $description;
    }

    public function setStart (string $start){
        $this->start = $start;
    }

    public function setEnd (string $end){
        $this->end = $end;
    }
}

?>