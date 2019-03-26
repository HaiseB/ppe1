<?php
require '../src/bootstrap.php';
logged_only();
if (is_admin() === false){
    e404();
    exit();
}
$pdo = get_pdo();

$req = $pdo->prepare("SELECT * FROM leagues WHERE id=?");
$req->execute([$_GET['id']]);
$league = $req->fetch();
$errors=[];

if (empty($league)){
    $_SESSION['flash']['danger'] = "La ligue que vous cherchez à modifier n'existe pas";
    header('location: league.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = $_POST;
    if (!empty($data)){
        if (empty($data['locked_at'])){
            $data['locked_at'] = NULL;
        } else {
            $data['locked_at'] = date("Y-m-d H:i:s");
        }
        $req = $pdo->prepare('UPDATE leagues SET name = ?, sport = ?, phone_number = ?, locked_at = ? WHERE id = ?');
        $req->execute([
            $data['name'],
            $data['sport'],
            $data['phone_number'],
            $data['locked_at'],
            $_GET['id']
        ]);
        $_SESSION['flash']['success'] = "la modification à été prise en compte";
        header('location: league.php');
        exit();
    } else{
        $_SESSION['flash']['danger'] = "Veuillez renseigner tout les champs obligatoires";
    }
}


render('header',['title' => $league['name']]);

?>

<div class="jumbotron container">
    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
            Merci de bien vouloir corriger vos erreurs
        </div>
    <?php endif; ?>
    <h1>Modifier la ligue <?= $league['name']; ?></h1>

    <form action="" method="POST" class="form">
        <?php render('league/form',['league' => $league, 'errors' => $errors]); ?>
        <div class="form-group">
            <button class="btn btn-primary">Valider le changement</button>
        </div>
    </form>

    <a href="deleteLeague.php?id=<?= $_GET['id'];?>" class="deleteButton"><i class="fas fa-dumpster"></i></a>
</div>

<?php render('footer'); ?>