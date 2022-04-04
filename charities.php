<?php

include 'config.php';

session_start();

// If user is not logged in, redirect to login page
if(!isset($_SESSION['Email'])) {
  header("Location: login.php");
  exit;
}

// Variables
$Charity_number = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Collect value of each field and validate it
  // Additional validation to be added HERE
  $Charity_number = $_POST['btn'];
  $Email = $_SESSION['Email'];

  $sql = $conn->prepare("INSERT INTO UserCharities (userEmail, charityNumber) VALUES (?, ?)");

  $sql->bind_param("si", $Email, $Charity_number);

  if ($sql->execute() === TRUE) {
    echo '<script>alert("Your request was sent successfully!")</script>';
  } else {
    echo '<script>alert("Request already sent!")</script>';
    echo "Execute failed: (" . $sql->errno . ") " . $sql->error;
  }

  // Close the sql query
  $sql->close();

}


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

    <style>

      /* Set the size of the div element that contains the map */
      #map {
        height: 675px;
        /* The height is 400 pixels */
        width: 100%;
        /* The width is the width of the web page */
      }

    </style>

  </head>

  <body>

  <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <a id = "link" class="navbar-brand" href="index.php">Volunteer @Bath</a>
          </div>
          <ul class="nav navbar-nav">
            <li><a class = "active" href="charities.php">Charities</a></li>
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

    <div class="row" style="margin-top:4%;">
      <div class="col-md-8">
        <!--The div element for the map -->
        <div id="map"></div>
      </div>
      <div class="col-md-4">
        <div class="container-scroll" id="scrollbox">
          <?php
          $stmt = $conn->prepare("SELECT * FROM charities");
          $stmt->execute();
          $result = $stmt->get_result();
          while($row = $result->fetch_assoc()){
          ?>
          <div class="card" style="padding-left:5px;padding-right:5px;padding-top:5px;" id="<?=$row['charityName'] ?>">

            <img class="card-img-top" src="<?=$row['charityImage']?>" alt="Charity logo" style="width: 100%;">
            <div class="card-body">
              <h2 class="card-title"><?= $row['charityName']?></h2>
              <h4 class="card-text">Cause served: <?=$row['charityType'] ?></h4>
              <p class="card-text">Task needed: <?=$row['task'] ?></p>
              <br>
              <p class="card-text">Address: <?=$row['address'] ?>,  <?=$row['postcode'] ?></p>
              <p class="card-text">Email: <?=$row['charityEmail'] ?>, Phone: <?=$row['phoneNumber'] ?></p>

              <?php if($row['minimumAge'] != 0){ ?>
              
              <p class="card-text">Minimum age required: <?=$row['minimumAge'] ?></p>

              <?php } ?>
              <?php if($row['carRequired'] == "Yes"){ ?>
              
              <p class="card-text"><b>A car is required for this task</b></p>

              <?php } ?>
              <?php if($row['DBSRequired'] == "Yes"){ ?>
              
              <p class="card-text"><b>A Disclosure and Barring Service (DBS) is required for this task</b></p>

              <?php } ?>

              <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <button type="submit" name="btn" class="btn btn-primary" value="<?php echo $row['charityNumber']; ?>" style="width:50%;margin-left:20%;margin-right:20%;">Send request</button>

              </form>

            </div>
            <hr>

          </div>

          <?php
          }
          // Close the sql query
          $stmt->close();
          ?>
        </div>
      </div>
    </div>
          
    <script>
      // Initialize and add the map
      function initMap() {
        // The location of Bath
        const Bath = { lat: 51.381926962210095, lng: -2.3590385412252766};
        // The map, centered
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 13,
          center: Bath,
        });
        // The markers, positioned at each charity
        const location = { lat: 51.37926749049669, lng: -2.356914185682831};
        const marker = new google.maps.Marker({
          position: location,
          map: map,
        });

        const location2 = { lat: 51.39187232324945, lng: -2.3544251045261153};
        const marker2 = new google.maps.Marker({
          position: location2,
          map: map,
        });

        const location3 = { lat: 51.37548903025406, lng: -2.321647931200209};
        const marker3 = new google.maps.Marker({
          position: location3,
          map: map,
        });

        const location4 = { lat: 51.38009687485119, lng: -2.3569211674749395};
        const marker4 = new google.maps.Marker({
          position: location4,
          map: map,
        });
      
      }
    </script>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwx0KSyW1Rv7GWtQcV-tLnBItf1De8yBs&callback=initMap&v=weekly"
      async
    ></script>
    
  </body>
</html>