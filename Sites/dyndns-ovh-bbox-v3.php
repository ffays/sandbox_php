<?php
header("Content-Type: text/plain");
if(!isset($_SERVER['PHP_AUTH_USER'])) {
	header('www-authenticate: Basic realm="What is your nic handle and password ??"');
	return;
}
$authorization = base64_encode($_SERVER['PHP_AUTH_USER'] . ':' . $_SERVER['PHP_AUTH_PW']);
$options = array('http' => array('method'  => 'GET', 'header' => 'Authorization: Basic ' . $authorization));
$context  = stream_context_create($options);
$url = 'https://www.ovh.com/nic/update?' . $_SERVER['QUERY_STRING'] . "&system=dyndns";
$response = file_get_contents($url, false, $context);
echo $response;
?>