<?php

$pdo = get_pdo();
$req = $pdo->query("SELECT * FROM leagues WHERE id>0");
$leagues = $req->fetchall();

pages('league/league',['title' => 'M2N - Liste des ligues', 'leagues' => $leagues]);