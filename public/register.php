<?php
require '../src/bootstrap.php';
session_start();
$pdo = get_pdo();

$req = $pdo->query("SELECT * FROM leagues WHERE id > 0");
$leagues = $req->fetchall();

if (!empty($_POST)){$errors = array();
    if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){
        $errors['username']="Votre nom d'utilisateur n'est pas valide";
    } else {
        $req = $pdo->prepare('SELECT id FROM users WHERE username=?');
        $req->execute([$_POST['username']]);
        $user = $req->fetch();
        if($user){
            $errors['username']="Ce nom d'utilisateur est déjà utilisé";
        }
    }
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email']="Votre mail n'est pas valide";
    } else {
        $req = $pdo->prepare('SELECT id FROM users WHERE email=?');
        $req->execute([$_POST['email']]);
        $email = $req->fetch();
        if($email){
            $errors['email']="Cet email est déjà utilisé";
        }
    }
    if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $errors['password']="Vous devez entrer un mot de passe";
    }
    if (empty($errors)){
        $req=$pdo->prepare("INSERT INTO users SET username = ?, email = ?, password = ?, confirmation_token = ?");
        $password=password_hash($_POST['password'], PASSWORD_DEFAULT);
        $token = str_random(60);
        $req->execute([$_POST['username'],$_POST['email'],$password, $token]);
        $user_id = $pdo->lastInsertId();
        mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien \n\nhttp://localhost/projet/public/confirm.php?id=$user_id&token=$token");
        $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
        header('location: login.php');
        exit();
    }
}

require '../views/header.php';
?>

<div class="jumbotron container">
    <h1>S'inscrire</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <p>Vous n'avez pas rempli tout les champs correctement</p>
            <ul>
                <?php foreach($errors as $error): ?>
                    <li><?= $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="">Nom d'utilisateur</label>
            <input type="text" name="username" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="email" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="">Mot de passe</label>
            <input type="password" name="password" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="">Confirmez votre mot de passe</label>
            <input type="password" name="password_confirm" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="">Choisissez votre ligue</label>
            <select class="form-control" id="exampleSelect1">
                <?php foreach ($leagues as $league):?>
                    <option><?= $league['name'] ;?> : <?= $league['sport'];?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-primary">M'inscrire</button>
        </div>
    </form>
</div>

<?php require '../views/footer.php'; ?>