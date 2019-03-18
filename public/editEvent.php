<?php
require '../src/bootstrap.php';
require '../src/calendar/Events.php';
require '../src/calendar/EventValidator.php';
logged_only();

$pdo = get_pdo();
$events = new calendar\Events($pdo);
$errors=[];
try{
    $event = $events->find($_GET['id'] ?? null);
}catch (\Exception $e){
    e404();
}catch (\Error $e){
    e404();
}

$data=[
    'name' => $event->getName(),
    'date' => $event->getStart()->format('Y-m-d'),
    'start' => $event->getStart()->format('H:i'),
    'end' => $event->getEnd()->format('H:i'),
    'description' => $event->getDescription(),
    'id_league' => $event->getId_league(),
    'id_classroom' => $event->getId_classroom(),
];

$req = $pdo->prepare("SELECT * FROM classrooms WHERE id = ?");
$req->execute([$data['id_classroom']]);
$classroom = $req->fetch();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = $_POST;
    if (empty($errors)){
        $pdo = get_pdo();
        $pdo->prepare('UPDATE events SET name = ? , description = ? WHERE id =?')->execute([$data['name'], $data['description'], $_GET['id']]);
        header('Location: calendar.php');
        exit();
    }
}

render('header',['title' => $event->getName()]);
?>

<div class="jumbotron container">
    <h1>Modifier l'évènement: <?= h($event->getName()); ?></h1>
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

<?php render('footer'); ?>