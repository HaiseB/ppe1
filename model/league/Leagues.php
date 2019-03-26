<?php

function getLeagues() : array{
    $pdo = get_pdo();
    $req = $pdo->query("SELECT * FROM leagues WHERE id > 0 ORDER BY name");
    $leagues = $req->fetchall();
    return $leagues;
}

function deleteLeague() : array{
    $pdo = get_pdo();
    $req = $pdo->prepare("SELECT * FROM leagues WHERE id=?");
    $req->execute([$_GET['id']]);
    $league = $req->fetch();
    
    if (empty($league)){
        $_SESSION['flash']['danger'] = "La ligue que vous cherchez à supprimer n'existe pas";
        header('location: index.php?action=league');
        exit();
    } else {
        $pdo->prepare('DELETE FROM leagues WHERE id = ?')->execute([$_GET['id']]);
        $_SESSION['flash']['danger'] = "La ligue à bien été supprimmée";
        header('location: index.php?action=league');
        exit();
    }
}

?>