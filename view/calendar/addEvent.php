<?php
require 'model/calendar/Events.php';
logged_only();
$pdo = get_pdo();

$data=[
    'date' => $_GET['date'] ?? date('Y-m-d'),
    'start' => $_GET['date'] ?? date('H:i'),
    'end' => $_GET['date'] ?? date('H:i')
];

$errors=[];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = $_POST;
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
        $league=$_SESSION['auth']['id_league'];
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
            header('Location: index.php?action=calendar');
            $_SESSION['flash']['success'] = "L'évènement à bien été créé";
            exit();
        } else {
            $_SESSION['flash']['danger'] = "Aucune salle ne peut remplir vos condittions";
        }
    } else {
        $_SESSION['flash']['danger'] = "Merci de bien vouloir corriger vos erreurs";
    }
}
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