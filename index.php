<?php

if (empty($_POST['payload'])){
	die('bad.');
}

require_once('Git.php');

$authorized = array('konsumer');

$n = getdate();

$timestamp = $n['mon'] . '-' . $n['mday'] . '-' . $n['year'] . ' '. $n['hours'] . ':' . $n['minutes'] . ':' . $n['seconds'];

// save request to log
file_put_contents('log.txt', $_SERVER['REMOTE_ADDR'] . ' - ' . $timestamp . ' - ' . $_POST['payload'] . "\n", FILE_APPEND | LOCK_EX);

$payload = json_decode($_POST['payload'], true);

foreach($payload['commmits'] as $commit){
	if (in_array($commit['committer']['username'], $authorized)){
		$repo_dir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'githook';

		$repo = Git::open($repo_dir, str_replace('https://', 'git@', $payload['repository']['url']) . '.git'));
	}
}