<?php
require '../src/bootstrap.php';
logged_only();
if (is_admin() === false){
    e404();
    exit();
}
$pdo = get_pdo();

$req = $pdo->prepare("SELECT * FROM classrooms WHERE id=?");
$req->execute([$_GET['id']]);
$classroom = $req->fetch();

if (empty($classroom)){
    $_SESSION['flash']['danger'] = "La salle que vous cherchez à supprimer n'existe pas";
    header('location: classroom.php');
    exit();
} else {
    $pdo->prepare('DELETE FROM classrooms WHERE id = ?')->execute([$_GET['id']]);
    $_SESSION['flash']['danger'] = "La salle à bien été supprimmée";
    header('location: classroom.php');
    exit();
}

?>