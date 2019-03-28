<?php
    require 'model/calendar/Events.php';
    $pdo = get_pdo();
    $events = new calendar\Events($pdo);
    $today = new \Datetime;
    
    $start = $today->format('Y-m-d 00:00:01');
    $end = $today->format('Y-m-d 23:59:59');
    $events = $events -> getEventsToday($start, $end);
    dd($events);
?>

<div class="jumbotron container">
    <h1>Voici ce que vous avez de prévu aujourd'hui <?= $_SESSION['auth']['username']; ?></h1>
    <br>
    <table class="table table-hover">
        <thead>
            <tr>
            <th scope="col">Horaire de début</th>
            <th scope="col">Horaire de fin</th>
            <th scope="col">Salle</th>
            <th scope="col">Cours</th>
            <th scope="col">Commentaire</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($events as $event): ?>
                <tr>
                    <th scope="row"><?= $event['start']; ?></th>
                    <th scope="row"><?= $event['end']; ?></th>
                    <td><?= getClassroomNameFromEvent($events);?> </td>
                    <td><?= $event['name'];?></td>
                    <td><?= $event['description'];?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>