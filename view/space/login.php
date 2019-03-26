<?php
reconnect_from_cookie();

if(isset($_SESSION['auth'])){
    header('location: account.php');
    exit();
}

if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
    $pdo=get_pdo();
    $req = $pdo->prepare('SELECT * FROM users WHERE username=? AND confirmed_at IS NOT NULL');
    $req->execute([$_POST['username']]);
    $user = $req->fetch();
    if(password_verify($_POST['password'], $user['password'])){
        $_SESSION['auth']=$user;
        $_SESSION['flash']['success'] = "Vous êtes maintenant connecté(e)";
        if ($_POST['remember']){
            $remember_token=str_random(255);
            $pdo->prepare('UPDATE users SET remember_token=? WHERE id=?')->execute([$remember_token,$user['id']]);
            setcookie('remember', $user['id'].'=='.$remember_token.sha1($user['id']. 'jaimelasecurite'), time()+ 60*60*24*7);
        }
        header('location: index.php?action=myDay');
        exit();
    }else{
        $_SESSION['flash']['danger'] = "Nom d'utilisateur et/ou mot de passe incorrect";
    }
}
?>

<div class="jumbotron container">
    <h1>Se connecter</h1>

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
            <label for="">Nom d'utilisateur ou email</label>
            <input type="text" name="username" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="">Mot de passe <a href='forget.php'>(mot de passe oublié)</a></label>
            <input type="password" name="password" class="form-control"/>
        </div>
        <div class="form-group">
            <label>
            <input type="Checkbox" name="remember" value="1"/> Se souvenir  de moi
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Me connecter</button>
        </div>
    </form>
</div>