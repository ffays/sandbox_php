<?php
header("Content-Type: text/plain");
foreach($_SERVER as $key => $value) { header("X-Debug-" . $key . ": "  . $value); }
echo nochg . " " . $_GET["myip"];
?>