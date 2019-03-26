<?php
    require 'model/calendar/Month.php';
    require 'model/calendar/Events.php';
    logged_only();
    $pdo = get_pdo();
    $events = new calendar\Events($pdo);
    $month = new calendar\Month($_GET['month'] ?? null, $_GET['year'] ?? null);
    $firstDay = $month->getFirstDay();
    $firstDay = $firstDay->format('N') === '1'? $firstDay : $month->getFirstDay()->modify('last monday');
    $weeks = $month->getWeeks();
    $end = (clone $firstDay)->modify('+'.(6 + 7* ($weeks-1).' days'));
    $events = $events -> getEventsBetweenByDay($firstDay, $end);
    $req = $pdo->prepare("SELECT * FROM classrooms WHERE id = ?");
?>

<div class="calendar">

    <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
        <h1><?= $month->toString(); ?></h1>
        <div>
            <a href="index.php?action=calendar&month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
            <a href="index.php?action=calendar&month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
        </div>
    </div>

    <table class="calendar__table calendar__table--<?= $weeks; ?>weeks">
        <?php for ($i = 0; $i < $weeks; $i++): ?>
            <tr>
                <?php foreach ($month->days as $k => $day):
                    $currentDay = (clone $firstDay)->modify("+". ($k + $i * 7) ."days");
                    $eventsForDay = $events[$currentDay->format('Y-m-d')] ?? [];
                    $isToday = date('Y-m-d') === $currentDay->format('Y-m-d');
                    ?>
                <td class="<?= $month->withinMonth($currentDay) ? '' : 'calendar__othermonth'; ?> <?= $isToday ? 'is-today' : ''; ?>">
                    <?php if ($i === 0):?>
                        <div class="calendar__weekday"><?= $day; ?></div>
                    <?php endif; ?>
                    <a class="calendar__day" href="index.php?action=addEvent&date=<?= $currentDay->format("Y-m-d"); ?>"><?= $currentDay->format("d"); ?></a>
                    <?php foreach ($eventsForDay as $event): ?>
                        <?php $req->execute([$event['id_classroom']]); $classroom = $req->fetch(); ?>
                        <div class="calendar__event">
                            <?= (new Datetime ($event['start']))->format('H:i') ?> : <a href="index.php?action=editEvent&id=<?= $event['id']; ?>">Salle <?= $classroom['name']?><br><?= $event['name']; ?></a>
                        </div>
                    <?php endforeach; ?>
                </td>
                <?php endforeach; ?>
            </tr>
        <?php endfor; ?>
    </table>

    <a href="index.php?action=addEvent" class="calendar__button">+</a>

</div>