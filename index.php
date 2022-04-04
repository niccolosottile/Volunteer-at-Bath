<?php 

include 'config.php';

session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>

    <title>Volunteering @Bath</title>

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
            <li><a id = "link" href="sign-up.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
          </ul>

          <?php } else { ?>
          
          <ul class="nav navbar-nav navbar-right">
            <li><a id = "link" href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>

          <?php }?>

        </div>
    </nav>

  <div class="slideshow-container">

    <div class="mySlides fade">
      <div class="numbertext">1 / 5</div>
      <img src="julianHouse.jpg" id ="slideImages">
      <div class="text">Julian House</div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">2 / 5</div>
      <img src="genesisTrust.jpg" id ="slideImages">
      <div class="myText text">Genesis Trust Souper November</div>
    </div>


    <div class="mySlides fade">
      <div class="numbertext">3 / 5</div>
      <img src="bathFoodBank.jpg" id ="slideImages">
      <div class="text">Bath Food Bank</div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">4 / 5</div>
      <img src="nationalAutisticSociety.jpg" id ="slideImages">
      <div class="text">National Autistic Society</div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">5 / 5</div>
      <img src="ageUK.png" id ="slideImages">
      <div class="text">Age UK</div>
    </div>

  </div>

  <div style="text-align:center">
    <span class="dot"></span> 
    <span class="dot"></span> 
    <span class="dot"></span> 
    <span class="dot"></span>
    <span class="dot"></span>
  </div>

  <script>
  let slideIndex = 0;
  showSlides();

  function showSlides() {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none"; 
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}    
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 4000);
  }
  </script>

  </body>
</html>