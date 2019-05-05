<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $pdo = get_pdo();
    $data = $_POST;
    if (!empty($data)){
        if (empty($data['locked_at'])){
            $data['locked_at'] = NULL;
        } else {
            $data['locked_at'] = date("Y-m-d H:i:s");
        }
        dd($data);
        $req = $pdo->prepare('INSERT INTO leagues(name, sport, phone_number, locked_at) VALUES (?, ?, ?, ?)');
        $req->execute([
            $data['name'],
            $data['sport'],
            $data['phone_number'],
            $data['locked_at']
        ]);
        $_SESSION['flash']['success'] = "la ligue est créée";
        header('location: index.php?action=league');
        exit();
    } else{
        $_SESSION['flash']['danger'] = "Veuillez renseigner tout les champs obligatoires";
    }
}

pages('league/addLeague',['title' => 'M2N - Nouvelle ligue']);