<?php

function getClassroomNameFromEvent($event){
    $pdo = get_pdo();
    $req = $pdo->prepare("SELECT * FROM classrooms WHERE id = ?");
    $req->execute([$event[0]['id_classroom']]);
    $classroom = $req->fetch();
    return $classroom['name'];
}