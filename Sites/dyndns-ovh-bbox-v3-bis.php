<?php
header("Content-Type: text/plain");
// foreach($_SERVER as $key => $value) { header("X-Debug-" . $key . ": "  . $value); }
if(!isset($_SERVER['HTTP_AUTHORIZATION'])) {
	header('www-authenticate: Basic realm="What is your nic handle and password ??"');
	return;
}
$options = array('http' => array('method'  => 'GET', 'header' => 'Authorization: ' . $_SERVER['HTTP_AUTHORIZATION']));
$context  = stream_context_create($options);
$url = 'https://www.ovh.com/nic/update?system=dyndns&hostname=' .  $_GET['hostname'] . '&myip=' . $_GET['myip'];
$response = file_get_contents($url, false, $context);
echo $response;
?>