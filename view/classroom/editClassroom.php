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