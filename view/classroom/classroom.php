<div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
    <h1>Salles de classe</h1>
</div>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Numéro</th>
            <th scope="col">Nombre de places</th>
            <th scope="col">Informatisée</th>
            <?php if( is_admin()):?>
                <th scope="col">Modifier</th>
            <?php endif;?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($classrooms as $classroom): ?>
            <tr class="<?= booked_now($classroom)? 'table-primary' : ''; ?><?= locked($classroom)? 'table-dark' : ''; ?>">
                <th scope="row"><?= $classroom['name'] ;?></th>
                <td><?= $classroom['id'];?></td>
                <td><?= $classroom['number_places'];?></td>
                <td><?= computerized($classroom)? '<i class="fas fa-desktop"></i>' : '';?></td>
                <?php if( is_admin()):?>
                    <td scope="col"><a href="index.php?action=editClassroom&id=<?= $classroom['id'];?>"><i class="fas fa-pen-nib"></i></a></td>
                <?php endif;?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if( is_admin()):?>
    <a href="index.php?action=addClassroom" class="calendar__button">+</a>
<?php endif;?>