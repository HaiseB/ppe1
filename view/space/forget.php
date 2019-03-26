<?php
if (!empty($_POST) && !empty($_POST['email'])){
    $pdo=get_pdo();
    $req = $pdo->prepare('SELECT * FROM users WHERE email=? AND confirmed_at IS NOT NULL');
    $req->execute([$_POST['email']]);
    $user = $req->fetch();
    if($user){
        $reset_token = str_random(60);
        $pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user['id']]);
        $_SESSION['flash']['success'] = "Un mail de réinitialisation de mot de passe vous à été envoyé";
        mail($_POST['email'], 'Réinitialisation de votre mot de passe', "Afin de réinitialiser de mot de passe merci de cliquer sur ce lien \n\nhttp://localhost/projet/public/reset.php?id={$user['id']}&token=$reset_token");
        $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
        header('location: login.php');
        exit();
    }else{
        $_SESSION['flash']['danger'] = "Aucun compte ne correspond à cet email";
    }
}
?>

<div class="jumbotron">
    <h1>Mot de passe oublié</h1>

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
            <label for="">Votre Email</label>
            <input type="text" name="email" class="form-control"/>
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Se connecter</button>
        </div>
    </form>
</div>