<?php

function getLeagues() : array{
    $pdo = get_pdo();
    $req = $pdo->query("SELECT * FROM leagues WHERE id > 0 ORDER BY name");
    $leagues = $req->fetchall();
    return $leagues;
}

?>