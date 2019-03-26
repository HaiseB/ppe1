<?php
require '../src/bootstrap.php';
logged_only();
if (is_admin() === false){
    e404();
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $pdo = get_pdo();
    $data = $_POST;
    if (!empty($data)){
        if (empty($data['locked_at'])){
            $data['locked_at'] = NULL;
        } else {
            $data['locked_at'] = date("Y-m-d H:i:s");
        }
        dd($data);
        $req = $pdo->prepare('INSERT INTO leagues(name, sport, phone_number, locked_at) VALUES (?, ?, ?, ?)');
        $req->execute([
            $data['name'],
            $data['sport'],
            $data['phone_number'],
            $data['locked_at']
        ]);
        $_SESSION['flash']['success'] = "la ligue est créée";
        header('location: league.php');
        exit();
    } else{
        $_SESSION['flash']['danger'] = "Veuillez renseigner tout les champs obligatoires";
    }
}


render('header',['title' => "Créaton d'une nouvelle salle"]);

?>

<div class="jumbotron container">
    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
            Merci de bien vouloir corriger vos erreurs
        </div>
    <?php endif; ?>
    <h1>Ajout d'une ligue</h1>

    <form action="" method="POST" class="form">
        <?php render('league/form'); ?>
        <div class="form-group">
            <button class="btn btn-primary">Créer la ligue</button>
        </div>
    </form>

</div>

<?php render('footer'); ?>