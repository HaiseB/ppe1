<?php
logged_only();
if (is_admin() === false){
    e404();
    exit();
}
$pdo = get_pdo();

$req = $pdo->prepare("SELECT * FROM classrooms WHERE id=?");
$req->execute([$_GET['id']]);
$classroom = $req->fetch();
$errors=[];

if (empty($classroom)){
    $_SESSION['flash']['danger'] = "La salle que vous cherchez à modifier n'existe pas";
    header('location: index.php?action=classroom');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = $_POST;
    if (!empty($data)){
        if (empty($data['computerized'])){
            $data['computerized'] = 0;
        } else {
            $data['computerized'] =1;
        }
        if (empty($data['locked_at'])){
            $data['locked_at'] = NULL;
        } else {
            $data['locked_at'] = date("Y-m-d H:i:s");
        }
        $req = $pdo->prepare('UPDATE classrooms SET name = ?, number_places = ?, computerized = ?, locked_at = ? WHERE id = ?');
        $req->execute([
            $data['name'],
            $data['number_places'],
            $data['computerized'],
            $data['locked_at'],
            $_GET['id']
        ]);
        $_SESSION['flash']['success'] = "la modification à été prise en compte";
        header('location: index.php?action=classroom');
        exit();
    } else{
        $_SESSION['flash']['danger'] = "Veuillez renseigner tout les champs obligatoires";
    }
}
?>

<div class="jumbotron container">
    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
            Merci de bien vouloir corriger vos erreurs
        </div>
    <?php endif; ?>
    <h1>Modifier la salle <?= $classroom['name']; ?></h1>

    <form action="" method="POST" class="form">
        <?php render('classroom/form',['classroom' => $classroom, 'errors' => $errors]); ?>
        <div class="form-group">
            <button class="btn btn-primary">Valider le changement</button>
        </div>
    </form>

    <a href="index.php?action=deleteClassroom&id=<?= $_GET['id'];?>" class="deleteButton"><i class="fas fa-dumpster"></i></a>
</div>