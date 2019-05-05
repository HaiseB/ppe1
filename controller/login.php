<?php

reconnect_from_cookie();

if(isset($_SESSION['auth'])){
    header('location: account.php');
    exit();
}

if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
    $pdo=get_pdo();
    $req = $pdo->prepare('SELECT * FROM users WHERE username=? AND confirmed_at IS NOT NULL');
    $req->execute([$_POST['username']]);
    $user = $req->fetch();
    if(password_verify($_POST['password'], $user['password'])){
        $_SESSION['auth']=$user;
        $_SESSION['flash']['success'] = "Vous êtes maintenant connecté(e)";
        if ($_POST['remember']){
            $remember_token=str_random(255);
            $pdo->prepare('UPDATE users SET remember_token=? WHERE id=?')->execute([$remember_token,$user['id']]);
            setcookie('remember', $user['id'].'=='.$remember_token.sha1($user['id']. 'jaimelasecurite'), time()+ 60*60*24*7);
        }
        header('location: index.php?action=myDay');
        exit();
    }else{
        $_SESSION['flash']['danger'] = "Nom d'utilisateur et/ou mot de passe incorrect";
    }
}

pages('space/login',['title' => 'M2N - Connexion']);