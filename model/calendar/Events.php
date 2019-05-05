<?php

namespace calendar;

require 'model\calendar\Event.php';

class Events{

    private $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo = $pdo;
    }

    /**
     * Recupère tout les évènements commencant entre 2 dates si l'utilisateur est admin sinon, elle ne recupère que ceux de la ligue
     *
     * @param \Datetime $start
     * @param \Datetime $end
     * @return array
     */
    public function getEventsBetween (\Datetime $start,\Datetime $end): array{
        if ( $_SESSION['auth']['id_league'] == 0 ){
            $sql = "SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}' ORDER BY start ASC";
            $statement = $this->pdo->query($sql);
        } else {
            $statement = $this->pdo->prepare("SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}' AND id_league = ? ORDER BY start ASC");
            $statement->execute([$_SESSION['auth']['id_league']]);
        }
        $result = $statement->fetchAll();
        return $result;
    }


    public function getEventsToday ($start,$end): array{
        $statement = $this->pdo->prepare("SELECT * FROM events WHERE start BETWEEN '{$start}' AND '{$end}' AND id_league = ? ORDER BY start ASC");
        $statement->execute([$_SESSION['auth']['id_league']]);
        $result = $statement->fetchAll();
        return $result;
    }

    public function deleteEvent(){
        $pdo = get_pdo();
        $req = $pdo->prepare("SELECT * FROM events WHERE id=?");
        $req->execute([$_GET['id']]);
        $event = $req->fetch();
        if (empty($event)){
            $_SESSION['flash']['danger'] = "L'évènement que vous cherchez à supprimer n'existe pas";
            header('location: index.php?action=calendar');
            exit();
        } else {
            $pdo->prepare('DELETE FROM events WHERE id = ?')->execute([$_GET['id']]);
            $_SESSION['flash']['success'] = "L'évènement à bien été supprimé";
            header('location: index.php?action=calendar');
            exit();
        }
    }

    /**
     * Recupère les évènements commencant entre 2 dates indexés par jour
     *
     * @param \Datetime $start
     * @param \Datetime $end
     * @return array
     */
    public function getEventsBetweenByDay (\Datetime $start,\Datetime $end): array{
        $events = $this->getEventsBetween($start, $end);
        $days = [];
        foreach ($events as $event){
            $date = explode (' ', $event['start'])[0];
            if (!isset($days[$date])){
                $days[$date] = [$event];
            } else{
                $days[$date][] = $event;
            }
        }
        return $days;
    }

    /**
     * Recupère un évènement
     *
     * @param integer $id
     * @return Event
     * @throws  \Exception
     */
    public function find (int $id): Event {
        $statement = $this->pdo->query("SELECT * FROM events WHERE id = $id LIMIT 1");
        $statement->setFetchMode(\PDO::FETCH_CLASS, Event::class);
        $result = $statement->fetch();
        if ($result === false){
            throw new \Exception("Aucun résultat n'a été trouvé.");
        }
        return $result;
    }

    /**
     * Créé un évènement au niveau de la BDD
     *
     * @param Event $event
     * @return boolean
     */
    public function create(Event $event) : bool {
        $statement = $this->pdo->prepare('INSERT INTO events(name, description, start, end) VALUES (?, ?, ?, ?)');
        return $statement->execute([
            $event->getName(),
            $event->getDescription(),
            $event->getStart()->format('Y-m-d H:i:s'),
            $event->getEnd()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Met à jour un évènement au niveau de la BDD
     *
     * @param Event $event
     * @return boolean
     */
    public function update(Event $event) : bool {
        $statement = $this->pdo->prepare('UPDATE events SET name = ?, description= ?, start = ?, end =? WHERE id = ?');
        return $statement->execute([
            $event->getName(),
            $event->getDescription(),
            $event->getStart()->format('Y-m-d H:i:s'),
            $event->getEnd()->format('Y-m-d H:i:s'),
            $event->getId()
        ]);
    }

    /**
     * Hydratation de l'objet
     *
     * @param Event $event
     * @param array $data
     * @return void
     */
    public function hydrate(Event $event, array $data){
        $event->setName($data['name']);
        $event->setDescription($data['description']);
        $event->setStart(\Datetime::createFromFormat('Y-m-d H:i', $data['date'].' '.$data['start'])->format('Y-m-d H:i:s'));
        $event->setEnd(\Datetime::createFromFormat('Y-m-d H:i', $data['date'].' '.$data['end'])->format('Y-m-d H:i:s'));
        return $event;
    }
}

?>