<?php
require '../src/bootstrap.php';
require '../src/calendar/Events.php';
require '../src/calendar/EventValidator.php';
logged_only();
$pdo = get_pdo();

$req = $pdo->prepare("SELECT id_league FROM users WHERE id=?");
$req->execute([$_SESSION['auth']['id']]);
$league = (int)$req->fetch();

$data=[
    'date' => $_GET['date'] ?? date('Y-m-d'),
    'start' => $_GET['date'] ?? date('H:i'),
    'end' => $_GET['date'] ?? date('H:i')
];

$validator = new app\Validator($data);
if (!$validator->validate('date', 'date')){
    $data['date'] = date('Y-m-d');
}

$errors=[];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = $_POST;
    //$validator = new calendar\EventValidator();
    //$errors = $validator->validates($_POST);
    if ($data['start'] >= $data['end']){
        $errors=['date'];
    }
    if (empty($errors)){
        $start=$data['date'].' '.$data['start'];
        $end=$data['date'].' '.$data['end'];
        $computerized = isset($data['computerized']) ? isCheckedComputerized($data['computerized'])? '1' : '0' : '0';
        $number_places = $data['number_places'];
        $name = $data['name'];
        $description = $data['description'];
        // utilisation de la procédure stockée
        $req = $pdo->prepare("CALL resSalle(?,?,?,?,?,?,?)");
        $req->execute([ $start,
                        $end,
                        $computerized,
                        $league,
                        $number_places,
                        $name,
                        $description]);
        if (1 === 1 /* A FAIRE : tester si la requete est passée */){
            header('Location: calendar.php');
            $_SESSION['flash']['success'] = "L'évènement à bien été créé";
            exit();
        } else {
            $_SESSION['flash']['danger'] = "Aucune salle ne peut remplir vos condittions";
        }
    } else {
        $_SESSION['flash']['danger'] = "Merci de bien vouloir corriger vos erreurs";
    }
}

render('header',['title' => 'Créer un évènement']);
?>

<div class="jumbotron container">
    <h1>Créer un évènement</h1>

    <form action="" method='post' class="form">
        <?php render('calendar/addForm',['data' => $data, 'errors' => $errors]); ?>
        <div class="form-group">
            <button class="btn btn-primary">Ajouter l'évènement</button>
        </div>
    </form>
</div>

<?php render('footer'); ?>