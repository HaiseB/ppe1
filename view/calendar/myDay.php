<?php
    require 'model/calendar/Events.php';
    $pdo = get_pdo();
    $events = new calendar\Events($pdo);
    $today = new \Datetime;
    $start = $today->format('Y-m-d 00:00:01');
    $end = $today->format('Y-m-d 23:59:59');
    $events = $events -> getEventsToday($start, $end);
?>

<div class="jumbotron container">
    <h1>Voici ce que vous avez de prévu aujourd'hui <?= $_SESSION['auth']['username']; ?></h1>
    <br>
    <?php if (!empty($events)) : ?>
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">Horaire</th>
                <th scope="col">Salle</th>
                <th scope="col">Intitulé du cours</th>
                <th scope="col">Commentaire</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($events as $event): ?>
                    <?php
                        $start= substr($event['start'],10);
                        $end= substr($event['end'],10);
                    ?>
                    <tr>
                        <td>De <?= $start; ?> à <?= $end; ?></td>
                        <td><?= getClassroomNameFromEvent($event);?> </td>
                        <td><?= $event['name'];?></td>
                        <td><?= $event['description'];?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        Oups! Il semblerait que vous n'ayez rien de prévu aujourd'hui.
    <?php endif; ?>
</div>