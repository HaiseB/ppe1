<?php
if (isset($_GET['id']) && isset($_GET['token'])){
    $pdo=get_pdo();
    $req = $pdo->prepare('SELECT * FROM users WHERE id=? AND reset_token =? AND reset_at > DATE_SUB(NOW(), INTERVAL 300 MINUTE)');
    $req->execute([$_GET['id'],$_GET['token']]);
    $user = $req->fetch();
    if($user){
        if (!empty($_POST)){
            if (!empty($_POST['password']) && $_POST['password'] === $_POST['password_confirm']){
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $pdo->prepare('UPDATE users SET password =?, reset_at = NUll, reset_token = NUll WHERE id=?')->execute([$password,$_GET['id']]);
                $_SESSION['flash']['success'] = 'Le changement de mot de passe à bien été effectué, bon retour parmis nous';
                $_SESSION['auth']=$user;
                header('location: index.php?action=account');
                exit();
            }else{
                $_SESSION['flash']['danger'] = "Les mot de passe sont ne correspondent pas";
            }
        }
    } else{
        $_SESSION['flash']['danger'] = "Ce lien à expiré";
        header('location: index.php?action=login');
        exit();
    }
} else{
    e404();
}
?>

<div class="jumbotron">
    <h1>Réinitialiser le mot de passe</h1>

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
            <label for="">Changer de mot de passe</label>
            <input type="password" name="password" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="">Confirmez votre nouveau mot de passe</label>
            <input type="password" name="password_confirm" class="form-control"/>
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Réinitialiser le mot de passe</button>
        </div>
    </form>
</div>
</div>