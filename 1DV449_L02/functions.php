<?php
require_once("get.php");
require_once("post.php");
require_once("sec.php");
sec_session_start();
//session_start();

/*
* It's here all the ajax calls goes
*/

if(isset($_GET['function'])) {

	/*if($_GET['function'] == 'logout') {

        unset($_SESSION['username']);
        unset($_SESSION['login_string']);
		logout();
    }*/



    if($_GET['function'] == 'add') {
	    $name = $_GET["name"];
        $message = $_GET["message"];
        addToDB($message, $name);
		//header("Location: test/debug.php");
    }
    /*elseif($_GET['function'] == 'getMessages') {

        $numOfMessagesOnClient = (int)$_GET['numOfMessages'];
        //$numOfMessagesOnDB = count(getMessages());

        $counter = 0;

        do{

            //usleep(5000000); // 1 sekund = 1000000 Mikro sekunder | Vänta i 5 sekunder innan fortsättning av exekvering (?)
            sleep(5); //Denna är vettigare, ingen gillar microsekunder...
            //clearstatcache(); // Ska tydligen hjälpa till servern att må bra (?)
            $numOfMessagesOnDB = count(getMessages()); // kollar om mer meddelanden har lagts till

            if($counter === 12){
                /*echo json_encode(getMessages());
                die();
                var_dump($numOfMessagesOnClient >= $numOfMessagesOnDB);
                var_dump($numOfMessagesOnClient);
                var_dump($numOfMessagesOnDB);
                die();
            }
            $counter++;

        }while($numOfMessagesOnClient >= $numOfMessagesOnDB );
        /*var_dump(getMessages());
        die();
  	   	echo json_encode(getMessages());
    }*/
}
if(isset($_POST["logout"])){
    unset($_SESSION['username']);
    unset($_SESSION['login_string']);
    header("Location: index.php");
}
//session_write_close();