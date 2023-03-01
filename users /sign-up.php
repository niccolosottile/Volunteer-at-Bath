<?php

include 'config.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>

    <title>Volunteer @Bath</title>

    <meta charset="utf-8">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Ensures proper rendering and touch zooming for specific device -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Linking stylesheet with page -->
    <link rel="stylesheet" href="style.css">

  </head>

  <body>

  <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <a id = "link" class="navbar-brand" href="index.php">Volunteer @Bath</a>
          </div>
          <ul class="nav navbar-nav">
            <li ><a id = "link" href="charities.php">Charities</a></li>
            <li><a id = "link" href="account.php">User preferences</a></li>
          </ul>
          <?php if(!isset($_SESSION['Email'])) { ?>

          <ul class="nav navbar-nav navbar-right">
            <li><a id = "link" href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <li><a class = "active" href="sign-up.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
          </ul>

          <?php } else { ?>
          
          <ul class="nav navbar-nav navbar-right">
            <li><a id = "link" href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>

          <?php }?>
        </div>
  </nav>


    <div class="container">
        <div id = "createAccount" class="jumbotron welcome-message">
            <h2>Are you a Charity or a Volunteer?</h2>
            <br>

            <form id = "buttons" action="charity-sign-up.php">

            <button type="submit" id = "myButton" class="btn btn-primary btn-lg">Charity</button>

            </form>

            <form id = "buttons" action="user-sign-up.php">

            <button type="submit" id = "myButton" class="btn btn-primary btn-lg">Volunteer</button>

            </form>

            <br>

        </div>
    </div>

  </body>
</html>
