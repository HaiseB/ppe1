<?php

$pdo = get_pdo();

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
        $req = $pdo->prepare('INSERT INTO classrooms(name, number_places, computerized, locked_at) VALUES (?, ?, ?, ?)');
        $req->execute([
            $data['name'],
            $data['number_places'],
            $data['computerized'],
            $data['locked_at']
        ]);
        $_SESSION['flash']['success'] = "la salle est créée";
        header('location: index.php?action=classroom');
        exit();
    } else{
        $_SESSION['flash']['danger'] = "Veuillez renseigner tout les champs obligatoires";
    }
}

pages('classroom/addClassroom',['title' => 'M2N - Nouvelle salle']);