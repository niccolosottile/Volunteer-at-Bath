<?php

include 'config.php';

// Declaring variables for each field
$Email = $Name = $DOB = $Contact_number = $Password = $Password_confirm = "";

// Declaring err variables for each field
$Email_err = $Name_err = $DOB_err = $Contact_number_err = $Password_err = $Password_confirm_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Collect value of each field and validate it
  // Additional validation to be added HERE
  if(empty(trim($_POST["Email"]))){
    $Email_err = "Please enter an email.";
  } else{
    $Email = trim($_POST["Email"]);
  }

  // Check that email is not already present in database
  $sql = $conn->prepare("SELECT userEmail FROM users WHERE userEmail = ?");

  $sql->bind_param("s", $Email);

  if ($sql->execute() === TRUE) {
    // Store the result
    $sql->store_result();

    // If Email is already taken, output error
    if ($sql->num_rows() == 1) {
      $Email_err = "This email is already taken.";
    }
  
  } else {
    echo "Execute failed: (" . $sql->errno . ") " . $sql->error;
  }

  // Close the sql query
  $sql->close();

  if(empty(trim($_POST["Name"]))){
    $Name_err = "Please enter your name.";
  } else{
    $Name = trim($_POST["Name"]);
  }

  if(empty(trim($_POST["DOB"]))){
    $DOB_err = "Please enter your date of birth.";
  } else{
    $DOB = trim($_POST["DOB"]);
  }

  if(empty(trim($_POST["Contact_number"]))){
    $Contact_number_err = "Please enter your phone number.";
  } else{
    $Contact_number = trim($_POST["Contact:_number"]);
  }

  if(empty(trim($_POST["Password"]))){
    $Password_err = "Please enter a password between 6 and 15 characters long.";
  } else{
    $Password = trim($_POST["Password"]);
  }

  if(empty(trim($_POST["Password_confirm"]))){
    $Password_confirm_err = "Please confirm your password.";
  } else{
    $Password_confirm = trim($_POST["Password_confirm"]);
  }

  if ($Password != $Password_confirm) {
    $Password_confirm_err = "Passwords do not match.";
  }

  // Insert record into database
  if (empty($Email_err) && empty($Name_err) && empty($DOB_err) && empty($Contact_number_err) && empty($Password_err) && empty($Password_confirm_err)) { 

    $sql = $conn->prepare("INSERT INTO users (userEmail, password, userName, DOB, contactNumber)
    VALUES (?, ?, ?, ?, ?)");

    $Hashed_password = password_hash($Password, PASSWORD_DEFAULT);

    $sql->bind_param("ssssi", $Email, $Hashed_password, $Name, $DOB, $Contact_number);

    if ($sql->execute() === TRUE) {
      header("Location: login.php");
      exit;
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

    <br>

    <div class="container">
        <div id = "createAccount" class="jumbotron" >
            <h2>Create an account!</h2>
            <br>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="Email">Email:</label>
                    <input type="text" class="form-control" id="Email" name="Email">
                    <span class="help-block"><?php echo $Email_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="Name">Name:</label>
                    <input type="text" class="form-control" id="Name" name="Name">
                    <span class="help-block"><?php echo $Name_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="DOB">Date of birth:</label>
                    <input type="date" class="form-control" id="DOB" name="DOB">
                    <span class="help-block"><?php echo $DOB_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="Contact_number">Contact number: </label>
                    <input type="text" class="form-control" id="Contact_number" name="Contact_number">
                    <span class="help-block"><?php echo $Contact_number_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="Password">Password:</label>
                    <input type="text" class="form-control" id="Password" name="Password">
                    <span class="help-block"><?php echo $Password_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="Password-confirm">Confirm password:</label>
                    <input type="text" class="form-control" id="Password-confirm" name="Password_confirm">
                    <span class="help-block"><?php echo $Password_confirm_err; ?></span>
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>

        </div>
    </div>

  </body>
</html>
