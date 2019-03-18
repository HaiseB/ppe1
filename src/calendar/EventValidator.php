<?php

namespace calendar;
require '../src/app/Validator.php';

use app\Validator;

class EventValidator extends Validator {

    /**
     * Utilisation de la fonction validator pour un évènement
     *
     * @param array $data
     * @return array|bool
     */
    public function validates(array $data) {
        parent::validates($data);
        $this->validate('name', 'minLength', 3);
        $this->validate('date', 'date');
        $this->validate('start', 'beforeTime', 'end');
        return $this->errors;
    }
}
?>