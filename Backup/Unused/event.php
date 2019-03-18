<?php
require '../src/bootstrap.php';
require '../src/calendar/Events.php';
logged_only();
$pdo = get_pdo();
$events = new calendar\Events($pdo);
try{
    $event = $events->find($_GET['id']);
}catch (\Exception $e){
    e404();
}
render('header',['title' => $event->getName()]);
?>

<h1><?= h($event->getName()); ?></h1>
<ul>
    <li>Date : <?= $event->getStart()->format('d/m/Y'); ?></li>
    <li>Heure de démarrage : <?= $event->getEnd()->format('H:i'); ?></li>
    <li>Heure de fin : <?= $event->getEnd()->format('H:i'); ?></li>
    <li>Description :<br>
        <?= h($event->getDescription()); ?></li>
</ul>

<?php require '../views/footer.php'; ?>

ancien affichage de reussite 

<?php if (isset($_GET['success'])): ?>
<div class="container">
            <div class="alert alert-success">
                L'évènement a bien été enregistré
            </div>
        </div>
        <?php endif; ?>