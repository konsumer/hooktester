<?php

if (empty($_POST['payload'])){
	die('bad.');
}

$n = getdate();

$timestamp = $n['mon'] . '-' . $n['mday'] . '-' . $n['year'] . ' '. $n['hours'] . ':' . $n['minutes'] . ':' . $n['seconds'];

// save request to log
file_put_contents('log.txt', $_SERVER['REMOTE_ADDR'] . ' - ' . $timestamp . ' - ' . $_POST['payload'] . "\n", FILE_APPEND | LOCK_EX);

$payload = json_decode($_POST['payload'], true);
