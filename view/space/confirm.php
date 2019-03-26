<?php
require '../src/bootstrap.php';

$pdo = get_pdo();
$user_id=$_GET['id'];
$token=$_GET['token'];
$req = $pdo->prepare('SELECT * FROM users where id=?');
$req->execute([$user_id]);
$user=$req->fetch();
session_start();

if($user && $user['confirmation_token'] == $token){
    $req = $pdo->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id=?')->execute([$user_id]);
    $_SESSION['flash']['success'] = 'Votre adresse à bien été validée';
    $_SESSION['auth']=$user;
    header('location: account.php');
} else {
    $_SESSION['flash']['danger'] = 'Le lien à expiré';
    header('location: login.php');
}

?>