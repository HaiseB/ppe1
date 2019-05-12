<?php

namespace calendar;

/**
 * Class month nécessaire au fonctionnement de l'agenda
 */
class Month{
    public $days=['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];

    private $months=['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Decembre'];
    public $month;
    public $year;

    /**
     * Month constructor
     * @param int $month le mois compris entre 1 et 12
     * @param int $year l'année
     * @throws \Exception
     */
    public function __construct(?int $month = null, ?int $year = null){
        if ($month === null || $month <1 || $month >12){
            $month = intval(date('m'));
        }
        if ($year === null){
            $year = intval(date('Y'));
        }
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * Renvoie le 1er jour du mois
     *
     * @return \Datetime
     */
    public function getFirstDay(): \Datetime {
        return new \Datetime("{$this->year}-{$this->month}-01");
    }

    /**
     * Retourne le mois en toute lettre ex: février 2019
     *
     * @return string
     */
    public function toString(): string {
        return $this->months[$this->month-1].' '.$this->year;
    }

    /**
     * Retourne un entier étant le nombre de semaine
     *
     * @return integer
     */
    public function getWeeks(): int {
        $start = $this->getFirstDay();
        $end = (clone $start)->modify('+1 month -1 day');
        $startWeek = intval($start->format('W'));
        $endWeek = intval($end->format('W'));
        if ( $endWeek === 1){
            $endWeek = intval((clone $end)->modify("-7 days")->format("W") + 1);
        }
        $weeks = $endWeek - $startWeek +1;
        if ($weeks < 0){
            $weeks = intval($end->format('W'));
        }
        return $weeks;
    }

    /**
     * Retourne 1 si le jour appartient au mois en cours
     *
     * @param \Datetime $date
     * @return boolean
     */
    public function withinMonth (\Datetime $date): bool {
        return $this->getFirstDay()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * Renvoie le mois suivant
     *
     * @return Month
     */
    public function nextMonth(): Month {
        $month = $this->month +1;
        $year = $this->year;
        if ($month > 12){
            $month = 1;
            $year += 1;
        }
        return new Month($month,$year);
    }

    /**
     * Renvoie le mois pécédant
     *
     * @return Month
     */
    public function previousMonth(): Month {
        $month = $this->month - 1;
        $year = $this->year;
        if ($month < 1){
            $month = 12;
            $year -= 1;
        }
        return new Month($month,$year);
    }
}

?>