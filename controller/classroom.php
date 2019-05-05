<?php
$pdo = get_pdo();

$req = $pdo->query("SELECT * FROM classrooms");
$classrooms = $req->fetchall();

pages('classroom/classroom',['title' => 'M2N - Liste des salles', 'classrooms' => $classrooms]);