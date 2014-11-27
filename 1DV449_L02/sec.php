<?php

/**
Just som simple scripts for session handling
*/
function sec_session_start() {
        $session_name = 'sec_session_id'; // Set a custom session name
        $secure = false; // Set to true if using https.
        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params(3600, $cookieParams["path"], $cookieParams["domain"], $secure, false);
        $httponly = true; // This stops javascript being able to access the session id.
        session_name($session_name); // Sets the session name to the one set above.
        session_start(); // Start the php session
        session_regenerate_id(); // regenerated the session, delete the old one.
}

/*function checkUser() {
	if(!session_id()) {
		sec_session_start();
	}

	if(!isset($_SESSION["user"])) {header('HTTP/1.1 401 Unauthorized'); die();}

	$user = getUser($_SESSION["user"]);
	$un = $user[0]["username"];

	if(isset($_SESSION['login_string'])) {
		if($_SESSION['login_string'] !== hash('sha512', "123456" + $un) ) {
			header('HTTP/1.1 401 Unauthorized'); die();
		}
	}
	else {
		header('HTTP/1.1 401 Unauthorized'); die();
	}
	return true;
}*/

function isUser($u, $p) {
	$db = null;
  /*  var_dump(password_hash($p, PASSWORD_DEFAULT));
        die();*/

	try {
		$db = new PDO("sqlite:db.db");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOEception $e) {
		die("Del -> " .$e->getMessage());
	}

    $query = "SELECT password FROM users WHERE username = ?";
    $param = [$u];
    $userHashedPass = "";
    try {
        $stm = $db->prepare($query);
        $stm->execute($param);
        $userHashedPass = $stm->fetch(PDO::FETCH_COLUMN);

        if(count($userHashedPass) < 0) {

            return "Could not find the user";
        }
    }
    catch(PDOException $e) {
        echo("Error creating query: " .$e->getMessage());
        return false;
    }

    /*var_dump(password_verify($p,$userHashedPass));
    die();*/
    $didItGoTrough = false;
    // didItGoTrough = password_verify($p,$userHashedPass); //<- Kan inte köras på mitt webbhotell. annars hade jag använt detta !!!!

    $didItGoTrough = checkIfPasswordIstrue($p,$userHashedPass);

    if($didItGoTrough){

        $q = "SELECT id FROM users WHERE username = ? AND password = ?";
        $param = [$u, $userHashedPass];

        //$result;
        //$stm;
        try {
            $stm = $db->prepare($q);
            $stm->execute($param);
            $result = $stm->fetchAll();

            if(count($result) < 0) {

                return "Could not find the user";
            }
        }
        catch(PDOException $e) {
            echo("Error creating query: " .$e->getMessage());
            return false;
        }
        return $result;
    }else{
        return false;
    }


	
}

//funktionen under används inte men ersätter password_verify
function checkIfPasswordIstrue($inputFromUser, $usersHashedPassword){
    //vi krypterar det inmatade lösenordet, testar om det är samma som användarens lösenord
    //om så är fallet så stämde lösenordet...

    $shouldBeSameAsHashed = crypt($inputFromUser, $usersHashedPassword);

    if($shouldBeSameAsHashed == $usersHashedPassword){
        return true;
    }else{
        return false;
    }
}

//funktionen under används inte men ersätter password_hash
function cryptPass($passwordToCrypt, $rounds = 9){
    //krypterar lösenordet med blowfish, har följt denna guide https://www.youtube.com/watch?v=wIRtl8CwgIc
    //returnerar det krypterade lösenordet
    //OBS: blowfish verkar kräva nyare version av php. version.5.2.12 verkar ej funka...
    $salt = "";

    //skapar en lång array med alla (typ) tecken från alfabetet + siffrorna 0-9
    $saltChars = array_merge(range("A","Z"), range("a","z"), range(0,9));

    for($i=0;$i < 22;$i++){ // for loop som ska utföras 22 gånger, Blowfish behöver 22 blandade tecken..
        $salt .= $saltChars[array_rand($saltChars)];
        //För varje "varv" så läggs en slumpad karaktär från arrayen in i strängen $salt (22blandade tecken)
    }

    //Nu ska vi kryptera och returnera det krypterade lösenordet!
    return crypt($passwordToCrypt, sprintf("$2y$%02d$", $rounds) . $salt);//
    // "$2y$%02d$" är den delen som gör att vi krypterar genom blowfish, endast "$2y$" är nödvändigt
    // det andra är "extra saker" som killen i videon sa var bra (lite svårare att kryptera...)
}

/*function getUser($user) {
	$db = null;

	try {
		$db = new PDO("sqlite:db.db");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOEception $e) {
		die("Del -> " .$e->getMessage());
	}
	$q = "SELECT * FROM users WHERE username = '$user'";

	$result;
	$stm;
	try {
		$stm = $db->prepare($q);
		$stm->execute();
		$result = $stm->fetchAll();
	}
	catch(PDOException $e) {
		echo("Error creating query: " .$e->getMessage());
		return false;
	}

	return $result;
}

function logout() {

	if(!session_id()) {
		sec_session_start();
	}
	session_end();
	header('Location: index.php');
}*/

