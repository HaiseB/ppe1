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
            <label for="">Mot de passe <a href='index.php?action=forget'>(mot de passe oublié)</a></label>
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