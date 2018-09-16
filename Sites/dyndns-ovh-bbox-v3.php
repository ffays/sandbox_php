<?php
header("Content-Type: text/plain");
$header = apache_request_headers();
if(!isset($header['Authorization'])) {
	header('www-authenticate: Basic realm="What is your nic handle and password ??"');
	return;
}
$options = array('http' => array('method'  => 'GET', 'header' => 'Authorization: ' . $header['Authorization']));
$context  = stream_context_create($options);
$url = 'https://www.ovh.com/nic/update?' . $_SERVER['QUERY_STRING'] . "&system=dyndns";
$response = file_get_contents($url, false, $context);
echo $response;
?>