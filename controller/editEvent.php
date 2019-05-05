<?php
require 'model/calendar/Events.php';

$pdo = get_pdo();
$events = new calendar\Events($pdo);
$errors=[];
try{
    $event = $events->find($_GET['id'] ?? null);
}catch (\Exception $e){
    e404();
}

$data=[
    'name' => $event->getName(),
    'date' => $event->getStart()->format('Y-m-d'),
    'start' => $event->getStart()->format('H:i'),
    'end' => $event->getEnd()->format('H:i'),
    'description' => $event->getDescription(),
    'id_league' => $event->getId_league(),
    'id_classroom' => $event->getId_classroom(),
];

$req = $pdo->prepare("SELECT * FROM classrooms WHERE id = ?");
$req->execute([$data['id_classroom']]);
$classroom = $req->fetch();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = $_POST;
    if (empty($errors)){
        $pdo = get_pdo();
        $pdo->prepare('UPDATE events SET name = ? , description = ? WHERE id =?')->execute([$data['name'], $data['description'], $_GET['id']]);
        header('Location: index.php?action=calendar');
        exit();
    }
}


pages('calendar/editEvent',['title' => 'M2N - Modifier', 'data' => $data, 'errors' => $errors, 'event' => $event, 'data' => $data, 'classroom' => $classroom]);