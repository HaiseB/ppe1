<?php

namespace app;

class Validator{

    private $data;

    protected $errors = [];

    public function __construct(array $data = []){
        $this->data = $data;
    }

    /**
     * Préparation à la fonction validate
     *
     * @param array $data
     * @return array|bool
     */
    public function validates(array $data) {
        $this->errors=[];
        $this->data=$data;
        return $this->errors;
    }

    /**
     * Undocumented function
     *
     * @param string $field
     * @param string $method
     * @param [type] ...$parameters
     * @return boolean
     */
    public function validate(string $field, string $method, ...$parameters) : bool {
        if (!isset($this->data[$field])){
            $this->errors[$field] = "Le champs $field n\'est pas remplis";
            return false;
        } else {
            return call_user_func([$this, $method], $field, ...$parameters);
        }
    }

    /**
     * vérification de la taille minimale du champ
     *
     * @param string $field
     * @param integer $length
     * @return boolean
     */
    public function minLength(string $field, int $length) : bool{
        if(mb_strlen($this->data[$field]) < $length){
            $this->errors[$field] = "Le camps doit avoir plus de $length caractères";
            return false;
        }
        return true;
    }

    /**
     * Vérification de la validitée du champ date sous le format a-m-j
     *
     * @param string $field
     * @return boolean
     */
    public function date(string $field) : bool{
        if (\DateTime::createFromFormat('Y-m-d', $this->data[$field]) === false){
            $this->errors[$field] = "La date ne semble pas valide";
            return false;
        }
        return true;
    }

    /**
     * Vérification de la validitée du champ date sous le format m:s
     *
     * @param string $field
     * @return boolean
     */
    public function time(string $field) : bool{
        if (\DateTime::createFromFormat('H:i', $this->data[$field]) === false){
            $this->errors[$field] = "Le temps ne semble pas valide";
            return false;
        }
        return true;
    }

    /**
     * Vérification si l'heure de fin est bien supérieure à l'heure de début
     *
     * @param string $startField
     * @param string $endField
     * @return void
     */
    public function beforeTime(string $startField, string $endField){
        if ($this->time($startField) && $this->time($endField)) {
            $start = \DateTime::createFromFormat('H:i', $this->data[$startField]);
            $end = \DateTime::createFromFormat('H:i', $this->data[$endField]);
            if ($start->getTimestamp() > $end->getTimestamp()){
                $this->errors[$startField] = "Le début doit être avant la fin";
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * vérification du nombre de place minimum dans une salle
     *
     * @param string $field
     * @param integer $length
     * @return boolean
     */
    public function minPlaces(int $field, int $length) : bool{
        if(mb_strlen($this->data[$field]) < $length){
            $this->errors[$field] = "Le camps doit avoir plus de $length caractères";
            return false;
        }
        return true;
    }
}
?>