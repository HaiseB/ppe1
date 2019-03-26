<?php
    require 'model/calendar/Events.php';
    $pdo = get_pdo();
    $events = new calendar\Events($pdo);
    $today = new \Datetime;
    $start = $today->format('Y-m-d 08:00:00');
    $end = $today->format('Y-m-d 18:30:00');
    $events = $events -> getEventsToday($start, $end);
    dd($events);
    dd($events[0]['name']);
    $req = $pdo->prepare("SELECT * FROM classrooms WHERE id = ?");
?>

<div class="jumbotron container">
    <h1>Voici ce que vous avez de prévu aujourd'hui <?= $_SESSION['auth']['username']; ?></h1>
    <br>
    <table class="table table-hover">
        <thead>
            <tr>
            <th scope="col"></th>
            <th scope="col">Salle</th>
            <th scope="col">Cours</th>
            <th scope="col">Commentaire</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 1; $i <= 11; $i++): ?>
                <tr>
                    <th scope="row"><?= 7+$i; ?> h 00</th>
                    <td><?php $req->execute(['$id_classroom']); $classroom = $req->fetch(); ?></td>
                    <td><?= $events[0]['name'];?></td>
                    <td><?= $events[0]['description'];?></td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</div>