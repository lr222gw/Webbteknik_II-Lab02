<?php
/**
 * Created by PhpStorm.
 * User: Lowe
 * Date: 2014-12-18
 * Time: 19:32
 */
require_once("get.php");
require_once("post.php");
require_once("sec.php");
//sec_session_start();
//session_start();

if($_GET['function'] == 'getMessages') {

/*    echo date(DATE_RSS);
    die();*/

    $numOfMessagesOnClient = (int)$_GET['numOfMessages'];
    //$numOfMessagesOnDB = count(getMessages());

    $counter = 0;

    do{

        //usleep(5000000); // 1 sekund = 1000000 Mikro sekunder | Vänta i 5 sekunder innan fortsättning av exekvering (?)
        if($counter != 0){
            sleep(5); //Denna är vettigare, ingen gillar microsekunder...
        }

        //clearstatcache(); // Ska tydligen hjälpa till servern att må bra (?)
        $numOfMessagesOnDB = count(getMessages()); // kollar om mer meddelanden har lagts till

        /*if($counter === 12){
            /*echo json_encode(getMessages());
            die();
            var_dump($numOfMessagesOnClient >= $numOfMessagesOnDB);
            var_dump($numOfMessagesOnClient);
            var_dump($numOfMessagesOnDB);
            die();
        }*/
        $counter++;

    }while($numOfMessagesOnClient >= $numOfMessagesOnDB );
    /*var_dump(getMessages());
    die();*/
    echo json_encode(getMessages());
}