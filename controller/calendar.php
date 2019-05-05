<?php

require 'model/calendar/Month.php';
require 'model/calendar/Events.php';

$pdo = get_pdo();
$events = new calendar\Events($pdo);
$month = new calendar\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
$firstDay = $month->getFirstDay();
$firstDay = $firstDay->format('N') === '1'? $firstDay : $month->getFirstDay()->modify('last monday');
$weeks = $month->getWeeks();
$end = (clone $firstDay)->modify('+'.(6 + 7* ($weeks-1).' days'));
$events = $events -> getEventsBetweenByDay($firstDay, $end);
$req = $pdo->prepare("SELECT * FROM classrooms WHERE id = ?");

pages('calendar/calendar',['title' => 'M2N - Calendrier', 'events' => $events, 'month' => $month, 'weeks' => $weeks, 'firstDay' => $firstDay, 'req' => $req]);