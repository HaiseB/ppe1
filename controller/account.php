<?php

$pdo = get_pdo();

$req = $pdo->query("SELECT * FROM leagues WHERE id > 0");
$leagues = $req->fetchall();

if (!empty($_POST)){
    if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $_SESSION['flash']['danger'] = 'Les mot de passe sont ne correspondent pas';
    } else {
        $user_id = $_SESSION['auth']['id'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $pdo = get_pdo();
        $pdo->prepare('UPDATE users SET password = ? WHERE id =?')->execute([$password, $user_id]);
        $_SESSION['flash']['success'] = 'Le changement à bien été effectué';
        header('location: index.php?action=myDay');
        exit();
    }
}

pages('space/account',['title' => 'M2N - Mon compte']);