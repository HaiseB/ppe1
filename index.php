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
            include 'controller/calendar.php';
        break;

        case "addEvent":
            logged_only();
            include 'controller/addEvent.php';
        break;

        case "editEvent":
            logged_only();
            include 'controller/editEvent.php';
        break;

        case "deleteEvent":
            logged_only();
            require 'model/calendar/Events.php';
            \calendar\Events::deleteEvent();
        break;
            
        case "classroom":
            logged_only();
            include 'controller/classroom.php';
        break; 

        case "editClassroom":
            admin_only();
            include 'controller/editClassroom.php';
        break;

        case "addClassroom":
            admin_only();
            include 'controller/addClassroom.php';
        break;

        case "deleteClassroom":
            admin_only();
            require 'model/classroom/Classrooms.php';
            deleteClassroom();
        break;
            
        case "league":
            logged_only();
            include 'controller/league.php';
        break;

        case "editLeague":
            admin_only();
            include 'controller/editleague.php';
        break;

        case "addLeague":
            admin_only();
            include 'controller/addLeague.php';
        break;

        case "deleteLeague":
            admin_only();
            include 'model/league/leagues.php';
            deleteLeague();
        break;
    }

?>