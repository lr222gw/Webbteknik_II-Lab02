<?php
require_once("sec.php");
sec_session_start();
if(isset($_SESSION['username']) && doTokenMatch()){
    header("Location: mess.php");
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="ico/favicon.png">
      <link rel="stylesheet" href="css/indexStyle.min.css"  >
    <title>Mezzy Labbage - Logga in</title>

    <!-- Bootstrap core CSS -->
      <script src="js/jquery.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">


		


  </head>

  <body>

    <div class="container">

      <form class="form-signin" action="check.php" method="POST">
        <h2 class="form-signin-heading">Log in</h2>
        <input value="" name="username" type="text" class="form-control" placeholder="Användarnamn" required autofocus>
        <input value="" name="password" type="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
      </form>
    </div> <!-- /container -->
    <!-- Custom styles for this template -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

