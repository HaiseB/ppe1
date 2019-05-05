<?php

/**
 * Renvoi vers page non trouvée
 *
 * @return void
 */
function e404(){
    http_response_code(404);
    pages('404');
    exit();
}

/**
 * Fonction d'affichage pour le débugage
 *
 * @param [type] ...$vars
 * @return void
 */
function dd(...$vars){
    foreach($vars as $var){
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}

/**
 * initialisation de la connexion avec la BDD
 *
 * @return PDO
 */
function get_pdo(): PDO {
    return new PDO('mysql:host=localhost;dbname=ppe1', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
}

/**
 * raccourcie pour utiliser la fonction htmlentities
 *
 * @param string|null $value
 * @return string
 */
function h(?string $value): string {
    if ($value === null){
        return '';
    }
    return htmlentities($value);
}

/**
 * inclue la page demandée
 *
 * @param string $view
 * @param array $parameters
 * @return view
 */
function render(string $view, $parameters =[]){
    extract($parameters);
    require "view/$view.php";
}

/**
 * génère une clé qui sert de contrecode
 *
 * @param [type] $length
 * @return void
 */
function str_random($length){
    $alphabet = "0123456789azertyuiopqsdfghjklmwwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

/**
 * Sécurisation d'une page pour ne donner l'accès qu'a un utilisateur connecté
 *
 * @return void
 */
function logged_only(){
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(!isset($_SESSION['auth'])){
        header('location: index.php?action=login');
        $_SESSION['flash']['danger'] = "Vous devez être connecté pour acceder à cette page";
        exit();
    }
}

/**
 * Sécurisation d'une page pour ne donner l'accès qu'a un administrateur
 *
 * @return void
 */
function admin_only(){
    logged_only();
    if($_SESSION['auth']['id_league'] !=0){
        header('location: index.php?action=account');
        $_SESSION['flash']['danger'] = "Vous devez être administrateur pour pouvvoir acceder à cette page";
        exit();
    }
}

/**
 * Permet une reconnexion si la case dans login.php à été cochée
 *
 * @return void
 */
function reconnect_from_cookie(){
    global $pdo;
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(isset($_COOKIE['remember']) && !isset($_SESSION['auth'])){
        $remember_token=$_COOKIE['remember'];
        $parts = explode('==', $remember_token);
        $user_id= $parts[0];
        $pdo=get_pdo();
        $req = $pdo->prepare('SELECT * FROM users WHERE id=?');
        $req->execute([$user_id]);
        $user=$req->fetch();
        if($user){
            $expected=$user_id.'=='.$user['remember_token'].sha1($user_id. 'jaimelasecurite');
            if($expected==$remember_token){
                $_SESSION['auth']=$user;
                setcookie('remember', $remember_token, time()+ 60*60*24*7);
                header('location: index.php');
                exit();
            } else{
                setcookie('remember', NULL, -1);
            }
        } else{
            setcookie('remember', NULL, -1);
        }
    }
}

/**
 * retourne vrai si l'utilisateur fait partie des administrateurs
 *
 * @return boolean
 */
function is_admin(): bool {
    if($_SESSION['auth']['id_league']==0){
        return true;
    }else{
        return false;
    }
}

/**
 * retourne vrai si l'utilisateur est connecté
 *
 * @return boolean
 */
function is_logged(): bool {
    if(!isset($_SESSION['auth'])){
        return false;
    }else{
        return true;
    }
}

/**
 * Undocumented function
 *
 * @param array $classroom
 * @return boolean
 */
function booked_now(array $classroom): bool{
    $pdo = get_pdo();
    $req = $pdo->prepare("SELECT * FROM events WHERE NOW() BETWEEN start AND end AND id_classroom=?");
    $req->execute([$classroom['id']]);
    $events = $req->fetch();
    if($events){
        return true;
    } else{
        return false;
    }
}

/**
 * Undocumented function
 *
 * @param array $classroom
 * @return boolean
 */
function locked(array $classroom): bool{
    $pdo = get_pdo();
    $req = $pdo->prepare("SELECT * FROM classrooms WHERE locked_at IS NOT NULL AND id=?");
    $req->execute([$classroom['id']]);
    $is_locked = $req->fetch();
    if($is_locked){
        return true;
    } else{
        return false;
    }
}

/**
 * Undocumented function
 *
 * @param array $classroom
 * @return boolean
 */
function leagueLocked(array $league): bool{
    $pdo = get_pdo();
    $req = $pdo->prepare("SELECT * FROM leagues WHERE locked_at IS NOT NULL AND id=?");
    $req->execute([$league['id']]);
    $is_locked = $req->fetch();
    if($is_locked){
        return true;
    } else{
        return false;
    }
}

/**
 * Retourne vrai si la salle est informatisée
 *
 * @param array $classroom
 * @return boolean
 */
function computerized(array $classroom): bool{
    if($classroom['computerized']){
        return true;
    } else{
        return false;
    }
}

/**
 * Retourne vrai la checkbox est cochée
 * @param boolean $checkbox
 * @return boolean
 */
function isCheckedComputerized(bool $checkbox): bool{
    if ($checkbox == 1) {
        return true;
    } else {
        return false;
    }
}

function isCheckedLocked_at(bool $checkbox): bool{
    if (empty($checkbox)) {
        return false;
    } else {
        return true;
    }
}

function pages($pageName, $parameters =[]){
    extract($parameters);
    render('header',$parameters);
    render($pageName,$parameters);
    render('footer');

}

function getClassroomNameFromEvent($event){
    $pdo = get_pdo();
    $req = $pdo->prepare("SELECT * FROM classrooms WHERE id = ?");
    $req->execute([$event['id_classroom']]);
    $classroom = $req->fetch();
    return $classroom['name'];
}

?>