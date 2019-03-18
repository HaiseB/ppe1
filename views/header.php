<?php if(session_status() == PHP_SESSION_NONE){
    session_start();
} ?>
<!Doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="css/calendar.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="shortcut icon" type="png" href="image/favicon.png"/>
        <title><?= isset($title) ? h($title) : 'M2N' ; ?></title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="index.php">Accueil</a>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <?php if (isset($_SESSION['auth'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="account.php">Mon compte</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="calendar.php">Calendrier</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="classroom.php">Salles de classe</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Se déconnecter</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Se connecter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">S'inscrire</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
        <div>
            <?php if(isset($_SESSION['flash'])): ?>
                <?php foreach($_SESSION['flash'] as $type => $message): ?>
                    <div class="alert alert-<?= $type; ?>">
                        <?= $message; ?>
                    </div>
                <?php endforeach; ?>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>
        </div>