<div class="jumbotron container">
    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
            Merci de bien vouloir corriger vos erreurs
        </div>
    <?php endif; ?>
    <h1>Créer une nouvelle salle</h1>

    <form action="" method="POST" class="form">
        <?php render('classroom/form'); ?>
        <div class="form-group">
            <button class="btn btn-primary">Créer la salle</button>
        </div>
    </form>

</div>