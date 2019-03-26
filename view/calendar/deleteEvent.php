<?php
require '../src/bootstrap.php';
logged_only();
$pdo = get_pdo();

$req = $pdo->prepare("SELECT * FROM events WHERE id=?");
$req->execute([$_GET['id']]);
$event = $req->fetch();

if (empty($event)){
    $_SESSION['flash']['danger'] = "L'évènement' que vous cherchez à supprimer n'existe pas";
    header('location: calendar.php');
    exit();
} else {
    $pdo->prepare('DELETE FROM events WHERE id = ?')->execute([$_GET['id']]);
    $_SESSION['flash']['success'] = "L'évènement à bien été supprimé";
    header('location: calendar.php');
    exit();
}

?>