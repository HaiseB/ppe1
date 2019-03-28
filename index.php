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

        case "forget":
            pages('space/forget');
        break;

        case "404":
            e404();
        break;

        case "logout":
            pages('space/logout');
        break;

        case "account":
            pages('space/account');
        break;

        case "myDay":
            include 'controller/myDay.php';
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
            logged_only();
            require 'model/league/Leagues.php';
            $leagues=getLeagues();
            render('header');
            include 'view/league/league.php';
            render('footer');
        break;

        case "editLeague":
            admin_only();
            pages('league/editLeague');
        break;

        case "addLeague":
            admin_only();
            pages('league/addLeague');
        break;

        case "deleteLeague":
            admin_only();
            include 'model/league/leagues.php';
            deleteLeague($_GET['id']);
        break;
    }

?>