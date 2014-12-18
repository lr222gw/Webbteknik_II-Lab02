<?php
require_once("sec.php");

// check tha POST parameters
$u = $_POST['username'];
$p = $_POST['password'];

// Check if user is OK
$loginString = hash('sha512', "123456" +$u); //<-- Detta är samma som CSRFToken va? isåfall ska den vara slumpad, vilket den typ blir...
if(isset($u) && isset($p) && isUser($u, $p, $loginString)) {
	// set the session
	sec_session_start();
	$_SESSION['username'] = $u;
	$_SESSION['login_string'] = $loginString;
	
	header("Location: mess.php");
    exit();
}
else {
	// To bad
	header('HTTP/1.1 401 Unauthorized');
	die("could not call");
}