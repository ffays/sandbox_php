<?php 

/**
 * Simple web based clipboard.
 * 
 * The clipboard can be retrieved by several browser instances by sharing the same PHP session identifier that is set via the variable PHPSESSID provided within the URL
 * This page tricks the PHP session mechanism by imposing a session identifier that is easily shareable amongst several browser instances.
 * The default session id will be the current day of the year (from 001 to 366) prefixed with "d" letter (e.g. the new year day's clipboard will be PHPSESSID=d001 and Christmas's clipboard will be PHPSESSID=d359)
 * @author Frederic Fays <github@fays.eu>
 * @license http://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License Version 3, 29 June 2007
 */
 
function do_redirect() {
	session_start();
	if(isset($_POST['clipboard'])) {
		$_SESSION['clipboard'] = $_POST['clipboard'];
	}
	$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	header("Location: //{$_SERVER['HTTP_HOST']}{$url}?" . session_name() . "=" . session_id());
	die();
}

function session_id_generator() {
	date_default_timezone_set('UTC');
	// return str_pad(dechex(mt_rand (1, 65535)), 4, "0", STR_PAD_LEFT)); // 4 hex digits
	return "d" . str_pad(date("z")+1, 3, "0", STR_PAD_LEFT); // day of the year
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // do post
    do_redirect();
} else  {
    // do get
    if(isset($_COOKIE[session_name()])) {
    	if(isset($_GET[session_name()])) {
    		if($_COOKIE[session_name()] == $_GET[session_name()]) {
    		 	// Display clipboard
    		 	session_start();
    		} else {
	    		// Switch session
				setcookie(session_name(),'',0,'/');
				session_id($_GET[session_name()]); 
				do_redirect();
    		}
    	} else {
    		// Missing session id in query string
			do_redirect();
    	}
    } else {
    	// New session
		session_id(isset($_GET[session_name()])?$_GET[session_name()]:session_id_generator()); 
		do_redirect();
    }
}
?><html>
<head>
<title>Clipboard</title>
<style>
.clipboard {
  height: 90%;
}

textarea {
  width: 100%;
  color: #000000;
  font-family: Consolas, monospace; 
  outline: none;
}

.unselectable { 
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
} 

input[type=submit] {
  font-size: 2em;
  -moz-border-radius: 10px;
  -webkit-border-radius: 10px;
  border-radius: 10px;    
}
</style>
</head>
<body onload="document.getElementById('clipboardText').select()">
<form action="<?php echo basename(__FILE__); ?>" method="post" id="clipboardForm">
<textarea id="clipboardText" name="clipboard" class="clipboard"><?php echo $_SESSION['clipboard']; ?></textarea><br>
<textarea rows="1" class="unselectable" placeholder="Press &#8679;&#x23ce; to submit / Press <?php echo preg_match('/macintosh/i', $_SERVER['HTTP_USER_AGENT'])?'&#8984;':'^' ?>C to copy" disabled ></textarea><br>
<input type="submit" class="unselectable">
</form>
<script>
document.getElementById('clipboardText').onkeyup=function(){
  if(event.keyCode==13 && event.shiftKey){
    document.getElementById('clipboardForm').submit(true)
  }
}
</script>
</body>
</html>
