<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
require 'model/functions.php';
?>

<?php

    if(!isset($_GET['action']))
        $_GET['action']="home";

    switch($_GET['action']) {

        case "home":
            pages('home');
        break;

        case "login":
            pages('space/login');
        break;

        case "logout":
            pages('space/logout');
        break;

        case "account":
            pages('space/account');
        break;

        case "myDay":
            pages('calendar/myDay');
        break;

        case "calendar":
            pages('calendar/calendar');
        break;

        case "addEvent":
            pages('calendar/addEvent');
        break;

        case "editEvent":
            pages('calendar/editEvent');
        break;

        case "classroom":
            pages('classroom/classroom',['title' => 'Liste des salles']);
        break;

        case "editClassroom":
            pages('classroom/editClassroom');
        break;

        case "addClassroom":
            pages('classroom/addClassroom');
        break;

        case "league":
            pages('league/league');
        break;

        case "editLeague":
            pages('league/editLeague');
        break;

        case "addLeague":
            pages('league/addLeague');
        break;

        case "deleteLeague":
            include 'controller/league.php';
        break;
    }
    


?>