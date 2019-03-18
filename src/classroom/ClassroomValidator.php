<?php

namespace Classroom;
require '../src/app/Validator.php';

use app\Validator;

class ClassroomValidator extends Validator {

    /**
     * Utilisation de la fonction validator pour une salle de classe
     *
     * @param array $data
     * @return array|bool
     */
    public function validates(array $data) {
        parent::validates($data);
        $this->validate('name', 'minLength', 3);
        $this->validate('date', 'date');
        return $this->errors;
    }
}
?>