<?php 
/**
 * Simple web based clipboard / session selector page.
 * 
 * @author Frederic Fays <github@fays.eu>
 * @license http://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License Version 3, 29 June 2007
 */
 
function get_clipboard_dot_php_url() {
	$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	return "https://{$_SERVER['HTTP_HOST']}{$url}"
}

function session_id_generator() {
	date_default_timezone_set('UTC');
	return "d" . str_pad(date("z")+1, 3, "0", STR_PAD_LEFT); // day of the year
}
?><html>
<head>
<title>Clipboard</title>
</head>
<body>
<form action="<?php echo get_clipboard_dot_php_url(); ?>">
PHPSESSID: <input type="text" name="PHPSESSID" value="<?php echo session_id_generator(); ?>">
<input type="submit">
</form>
</body>
</html>
