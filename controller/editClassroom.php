<?php

$pdo = get_pdo();
$req = $pdo->prepare("SELECT * FROM classrooms WHERE id=?");
$req->execute([$_GET['id']]);
$classroom = $req->fetch();
$errors=[];

if (empty($classroom)){
    $_SESSION['flash']['danger'] = "La salle que vous cherchez à modifier n'existe pas";
    header('location: index.php?action=classroom');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = $_POST;
    if (!empty($data)){
        if (empty($data['computerized'])){
            $data['computerized'] = 0;
        } else {
            $data['computerized'] =1;
        }
        if (empty($data['locked_at'])){
            $data['locked_at'] = NULL;
        } else {
            $data['locked_at'] = date("Y-m-d H:i:s");
        }
        $req = $pdo->prepare('UPDATE classrooms SET name = ?, number_places = ?, computerized = ?, locked_at = ? WHERE id = ?');
        $req->execute([
            $data['name'],
            $data['number_places'],
            $data['computerized'],
            $data['locked_at'],
            $_GET['id']
        ]);
        $_SESSION['flash']['success'] = "la modification à été prise en compte";
        header('location: index.php?action=classroom');
        exit();
    } else{
        $_SESSION['flash']['danger'] = "Veuillez renseigner tout les champs obligatoires";
    }
}

pages('classroom/editClassroom',['title' => 'M2N - Modifier', 'classroom' => $classroom, 'errors' => $errors]);