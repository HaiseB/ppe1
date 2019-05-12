<?php

/**
 * recupère la liste de toutes les ligues excepté la "ligue" administration
 *
 * @return array
 */
function getLeagues() : array{
    $pdo = get_pdo();
    $req = $pdo->query("SELECT * FROM leagues WHERE id > 0 ORDER BY name");
    $leagues = $req->fetchall();
    return $leagues;
}

/**
 * Supprimme une ligue de sport en fonction de l'id récupéré en GEt
 *
 * @return array
 */
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
        $_SESSION['flash']['success'] = "La ligue à bien été supprimée";
        header('location: index.php?action=league');
        exit();
    }
}

?>