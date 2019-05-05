<div class="jumbotron container">
    <h1>Modifier l'évènement: <?= h($data['name']); ?></h1>
    <hr>
    <h3>Salle <?= $classroom['name']; ?> : le <?= $data['date']; ?> de <?= $data['start']; ?> à <?= $data['end']; ?></h3>
    <form action="" method='post' class="form">
        <?php render('calendar/editForm',['data' => $data, 'errors' => $errors]); ?>
        <div class="form-group">
            <button class="btn btn-primary">Modifier l'évènement</button>
        </div>
    </form>
</div>

<a href="deleteEvent.php?id=<?= $_GET['id'];?>" class="deleteButton"><i class="fas fa-dumpster"></i></a>