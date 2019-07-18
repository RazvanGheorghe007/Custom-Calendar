<?php
include 'calendar.php';

$year = $_GET['year'];
$month = $_GET['month'];
$index = $_GET['index'];

$calendar = new Calendar(); 
if ($index == 1) {
    $day = $_GET['day'];
    $return = $calendar->getday($year, $month, $day);
    echo($return);
} else {
    $return = $calendar->show();
    echo($return);
}
?>