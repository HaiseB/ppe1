<div class="jumbotron">
    <h1>Mot de passe oublié</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <p>Vous n'avez pas remplis tout les champs correctement</p>
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