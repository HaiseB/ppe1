<?php

$pdo = get_pdo();

$req = $pdo->prepare("SELECT * FROM leagues WHERE id=?");
$req->execute([$_GET['id']]);
$league = $req->fetch();
$errors=[];

if (empty($league)){
    $_SESSION['flash']['danger'] = "La ligue que vous cherchez à modifier n'existe pas";
    header('location: index.php?action=league');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = $_POST;
    if (!empty($data)){
        if (empty($data['locked_at'])){
            $data['locked_at'] = NULL;
        } else {
            $data['locked_at'] = date("Y-m-d H:i:s");
        }
        $req = $pdo->prepare('UPDATE leagues SET name = ?, sport = ?, phone_number = ?, locked_at = ? WHERE id = ?');
        $req->execute([
            $data['name'],
            $data['sport'],
            $data['phone_number'],
            $data['locked_at'],
            $_GET['id']
        ]);
        $_SESSION['flash']['success'] = "la modification à été prise en compte";
        header('location: index.php?action=league');
        exit();
    } else{
        $_SESSION['flash']['danger'] = "Veuillez renseigner tout les champs obligatoires";
    }
}

pages('league/editLeague',['title' => 'M2N - Modifier', 'league' => $league, 'errors' => $errors]);