<?php

function logout(){
    setcookie('remember', NULL, -1);
    unset($_SESSION['auth']);
    $_SESSION['flash']['success'] = 'Vous êtes maintenant déconnecté(e)';
    header('location: index.php?action=login');
}