<?php
    require_once("sec.php");
	require_once("get.php");
    sec_session_start();

    header('Expires: '.gmdate('D, d M Y H:i:s G\M\T', time() + 89400));//nån gång imorgon...
/*var_dump(gmdate('D, d M Y H:i:s G\M\T', time() + 89400));*/
//var_dump($_SESSION["username"]);
if(isset($_SESSION["username"]) == false || doTokenMatch() == false){
    header('HTTP/1.1 401 Unauthorized');
    die("could not call");
}
?>
<!DOCTYPE html>
<html lang="sv">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="apple-touch-icon" href="touch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="touch-icon-ipad-retina.png">
    <link rel="shortcut icon" href="pic/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
      <link rel="stylesheet" type="text/css" href="css/style.min.css" />
   

	

    
	<title>Messy Labbage</title>
  </head>

	  	<body background="http://www.lockley.net/backgds/big_leo_minor.jpg">        

        <div id="container">
            
            <div id="messageboard">
                <form method="post" action="functions.php">
                    <input type="submit" class="btn btn-danger"  id="buttonLogout" name='logout' value="Logout" style="margin-bottom: 20px;" />
                </form><!--Kan jag spara i SessionToken här? Varför går/inte Det? -->
                <div id="messagearea"></div>



                <p id="numberOfMess">Antal meddelanden: <span id="nrOfMessages">0</span></p>
                Name:<br /> <input id="inputName" type="text" name="name" /><br />
                Message: <br />
                <textarea name="mess" id="inputText" cols="55" rows="6"></textarea>
                <input class="btn btn-primary" type="button" id="buttonSend" value="Write your message" />
                <input id="superCoolToken" type="hidden" name="superCoolToken" value="<? echo $_SESSION["sessionToken"] = generateRandomString(); ?>">
                <span class="clear">&nbsp;</span>

            </div>

        </div>
        

        <script src="js/jquery.min.js"></script>
        <script src="MessageBoard.js"></script> <!--"MessageBoard.min.js" -->
        <!--<script src="js/script.min.js"></script>-->
        <script src="Message.min.js"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <!--<script type="text/javascript" src="js/longpoll.js"></script>-->

        <!-- This script is running to get the messages -->
			<!--<script src="js/script.min.js"></script>-->
			<script src="js/bootstrap.min.js"></script>


	</body>
	</html>

<?
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}