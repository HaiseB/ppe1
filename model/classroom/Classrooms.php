<?php

/**
 * Supprimme une salle de classe en fonction de l'id récupéré en GEt
 *
 * @return array
 */
function deleteClassroom() : array{
    $pdo = get_pdo();
    $req = $pdo->prepare("SELECT * FROM classrooms WHERE id=?");
    $req->execute([$_GET['id']]);
    $classroom = $req->fetch();
    if (empty($classroom)){
        $_SESSION['flash']['danger'] = "La salle que vous cherchez à supprimer n'existe pas";
        header('location: index.php?action=classroom');
        exit();
    } else {
        $pdo->prepare('DELETE FROM classrooms WHERE id = ?')->execute([$_GET['id']]);
        $_SESSION['flash']['danger'] = "La salle à bien été supprimmée";
        header('location: index.php?action=classroom');
        exit();
    }
}