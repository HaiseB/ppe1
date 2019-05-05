<div class="jumbotron container">
    <h1>Créer un évènement</h1>

    <form action="" method='post' class="form">
        <?php render('calendar/addForm',['data' => $data, 'errors' => $errors]); ?>
        <div class="form-group">
            <button class="btn btn-primary">Ajouter l'évènement</button>
        </div>
    </form>
</div>