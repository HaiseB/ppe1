<?php
logged_only();
if (is_admin() === false){
    e404();
    exit();
}

include 'model/league/leagues.php';
deleteLeague($_GET['id']);
