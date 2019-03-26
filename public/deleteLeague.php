<?php
require '../src/bootstrap.php';
logged_only();
if (is_admin() === false){
    e404();
    exit();
}
$pdo = get_pdo();

$req = $pdo->prepare("SELECT * FROM leagues WHERE id=?");
$req->execute([$_GET['id']]);
$league = $req->fetch();

if (empty($league)){
    $_SESSION['flash']['danger'] = "La ligue que vous cherchez à supprimer n'existe pas";
    header('location: league.php');
    exit();
} else {
    $pdo->prepare('DELETE FROM leagues WHERE id = ?')->execute([$_GET['id']]);
    $_SESSION['flash']['danger'] = "La ligue à bien été supprimmée";
    header('location: league.php');
    exit();
}

?>