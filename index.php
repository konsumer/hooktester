<?php

if (empty($_POST['payload'])){
	die('bad.');
}

// save request to log
file_put_contents('log.txt', $_POST['payload']+"\n\n", FILE_APPEND | LOCK_EX);

$payload = json_decode($_POST['payload'], true);

