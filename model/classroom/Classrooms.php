<?php

namespace Classroom;

require '..\src\classroom\Classroom.php';

class Classrooms{
    private $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;
    }
}

?>