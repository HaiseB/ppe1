<?php

function getClassroomNameFromEvent($event){
    $pdo = get_pdo();
    $req = $pdo->prepare("SELECT * FROM classrooms WHERE id = ?");
    $req->execute([$event['id_classroom']]);
    $classroom = $req->fetch();
    return $classroom['name'];
}