<?php
require '../src/bootstrap.php';
render('header');
?>

<div class="jumbotron container">
    <h1>Bienvenue sur le site Web de la Maison des ligues</h1>
</div>

<div class="jumbotron container">
    <h1>Comment utiliser le site?</h1>
</div>

<div class="jumbotron container">
    <h1>En construction</h1>
    <ul>
        <li>tri des salles selon critères</li>
        <li>Test si la procédure stockée est bien passée</li>
        <li>affichage hebdomadaire</li>
        <li>validator class et league</li>
        <li>register.php & account.php</li>
    </ul>
</div>

<div class="jumbotron container">
    <h1>À venir :</h1>
    <ul>
        <li>changer de ligue dans account</li>
        <li>Ajout de la possibilité de reserver depuis l'écran de salles de classe</li>
        <li>Modification/ajout de ligues pour l'Admin</li>
        <li>Page spécifique pour la création d'évènement</li>
        <li>bouton contacter Admin</li>
        <li>Themes personnalisées</li>
        <li>Messagerie interne</li>
    </ul>
</div>


<?php render('footer'); ?>