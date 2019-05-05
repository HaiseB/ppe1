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
            include 'controller/home.php';
        break;

        case "login":
            include 'controller/login.php';
        break;

        case "forget":
            include 'controller/forget.php';
        break;

        case "404":
            e404();
        break;

        case "logout":
            include 'model/space/Space.php';
            logout();
        break;

        case "account":
            logged_only();
            include 'controller/account.php';
        break;

        case "myDay":
            logged_only();
            include 'controller/myDay.php';
        break;

        case "calendar":
            logged_only();
            pages('calendar/calendar');
        break;

        case "addEvent":
            logged_only();
            include 'controller/addEvent.php';
        break;

        case "editEvent":
            logged_only();
            include 'controller/editEvent.php';
        break;

        case "classroom":
            logged_only();
            pages('classroom/classroom',['title' => 'Liste des salles']);
        break; 

        case "editClassroom":
            admin_only();
            pages('classroom/editClassroom');
        break;

        case "addClassroom":
            admin_only();
            include 'controller/addClassroom.php';
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