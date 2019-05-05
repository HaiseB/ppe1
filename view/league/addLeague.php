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