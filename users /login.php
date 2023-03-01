<?php

include 'config.php';

// Declaring variables for each field
$Email = $Password = "";

// Declaring err variables for each field
$Email_err = $Password_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Collect value of each field and validate it
  // Additional validation to be added HERE
  if(empty(trim($_POST["Email"]))){
    $Email_err = "Please enter your email.";
  } else{
    $Email = trim($_POST["Email"]);
  }

  if(empty(trim($_POST["Password"]))){
    $Password_err = "Please enter your password.";
  } else{
    $Password = trim($_POST["Password"]);
  }

  // Check if email and password matches
  if (empty($Email_err) && empty($Password_err)) { 

    // Retrieve login values from database
    $sql = $conn->prepare("SELECT userEmail, Password FROM users WHERE userEmail = ?");

    $sql->bind_param("s", $Email);

    if ($sql->execute() === TRUE) {
      // Store the result
      $sql->store_result();

      // If email is not present, output error message
      if ($sql->num_rows() == 0) {
        $Email_err = "Enter a correct email.";
      }
      else {

        $Hashed_password = "";

        // If email is present, check that the password matches
        $sql->bind_result($Email, $Hashed_password);

        if($sql->fetch()) {
          
          if(password_verify($Password, $Hashed_password)) {

            // Start new session
            session_start();

            // Save session variables
            $_SESSION['Email'] = $Email;

            header("Location: charities.php");
            exit;
          }
          else {
            $Password_err = "Password not correct.";
          }

        }
      }
    
    } else {
      echo "Execute failed: (" . $sql->errno . ") " . $sql->error;
    }

    // Close the sql query
    $sql->close();
  }

  // Close database connection
  $conn->close();

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
            <li><a class = "active" href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <li><a href="sign-up.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
          </ul>

          <?php } else { ?>
          
          <ul class="nav navbar-nav navbar-right">
            <li><a id = "link" href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>

          <?php }?>
        </div>
  </nav>

    <br>

    <div class="container">
      <div class="jumbotron welcome-message" id="createAccount">
          <h2>Login!</h2>
          <br>
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <div class="form-group">
                  <label for="Email">Email:</label>
                  <input type="text" class="form-control" id="Email" name="Email">
                  <span class="help-block"><?php echo $Email_err; ?></span>
              </div>
              <div class="form-group">
                  <label for="Password">Password:</label>
                  <input type="text" class="form-control" id="Password" name="Password">
                  <span class="help-block"><?php echo $Password_err; ?></span>
              </div>
              <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
              </label>
              <br>
              <button type="submit" class="btn btn-default">Submit</button>
          </form>

      </div>
  </div>

  </body>
</html>
