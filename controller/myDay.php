<?php

require 'model/calendar/Events.php';

$pdo = get_pdo();
$events = new calendar\Events($pdo);
$today = new \Datetime;
$start = $today->format('Y-m-d 00:00:01');
$end = $today->format('Y-m-d 23:59:59');
$events = $events -> getEventsToday($start, $end);

pages('calendar/myDay',['title' => 'M2N - Votre journée', 'events' => $events]);