<?php
require '../src/bootstrap.php';
require '../src/league/Leagues.php';

logged_only();
$leagues=getLeagues();

render('header',['title' => 'Liste des ligues']);
?>

<div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
    <h1>Ligues de sport</h1>
</div>
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Sport</th>
            <th scope="col">Numéro de téléphone</th>
            <?php if( is_admin()):?>
                <th scope="col">Modifier</th>
            <?php endif;?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($leagues as $league): ?>
            <tr class="<?= leagueLocked($league)? 'table-dark' : ''; ?>">
                <th scope="row"><?= $league['name'] ;?></th>
                <td><?= $league['sport'];?></td>
                <td><?= $league['phone_number'];?></td>
                <?php if( is_admin()):?>
                    <td scope="col"><a href="editLeague.php?id=<?= $league['id'];?>"><i class="fas fa-pen-nib"></i></a></td>
                <?php endif;?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if( is_admin()):?>
    <a href="addLeague.php" class="calendar__button">+</a>
<?php endif;?>

<?php render('footer'); ?>