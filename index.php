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

$do_pull = FALSE;

foreach($payload['commmits'] as $commit){
	if (in_array($commit['committer']['username'], $authorized)){
		$do_pull = TRUE;
		break;
	}
}

if (!$do_pull){
	header("HTTP/1.0 403 Forbidden");
	die("No committers are authorized.");
}

$repo_dir = tempnam(sys_get_temp_dir(), 'github-hook'); unlink($repo_dir); mkdir($repo_dir);
$repo = Git::open($repo_dir, str_replace('https://', 'git@', $payload['repository']['url']) . '.git'));
