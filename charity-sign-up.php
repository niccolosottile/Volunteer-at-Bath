<?php

include 'config.php';

// Declaring variables for each field
$Charity_number = $Name = $Address = $Postcode = $Email = $Contact_number = $Charity_type = $Task = $Minimum_age = $Car_required = $DBS_required = $Password = $Password_confirm = "";

// Declaring err variables for each field
$Charity_number_err = $Name_err = $Address_err = $Postcode_err = $Email_err = $Contact_number_err = $Charity_type_err = $Task_err = $Minimum_age_err = $Car_required_err = $DBS_required_err = $Password_err = $Password_confirm_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Collect value of each field and validate it
  // Additional validation to be added HERE
  if(empty(trim($_POST["Charity_number"]))){
    $Charity_number_err = "Please enter your government associated charity number.";
  } else{
    $Charity_number = trim($_POST["Charity_number"]);
  }

  // Check that email is not already present in database
  $sql = $conn->prepare("SELECT charityNumber FROM charities WHERE charityNumber = ?");

  $sql->bind_param("s", $Charity_number);

  if ($sql->execute() === TRUE) {
    // Store the result
    $sql->store_result();

    // If Email is already taken, output error
    if ($sql->num_rows() == 1) {
      $Email_err = "A charity account with this charity number has already been created.";
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

  if(empty(trim($_POST["Email"]))){
    $Email_err = "Please enter your email.";
  } else{
    $Email = trim($_POST["Email"]);
  }

  if(empty(trim($_POST["Address"]))){
    $Address_err = "Please enter your address.";
  } else{
    $Address = trim($_POST["Address"]);
  }

  if(empty(trim($_POST["Postcode"]))){
    $Postcode_err = "Please enter your postcode.";
  } else{
    $Postcode = trim($_POST["Postcode"]);
  }

  if(empty(trim($_POST["Contact_number"]))){
    $Contact_number_err = "Please enter your phone number.";
  } else{
    $Contact_number = trim($_POST["Contact_number"]);
  }

  if(empty(trim($_POST["Charity_type"]))){
    $Charity_type_err = "Please select a charity type.";
  } else{
    $Charity_type = trim($_POST["Charity_type"]);
  }

  if(empty(trim($_POST["Task"]))){
    $Task_err = "Describe the task that needs to be done.";
  } else{
    $Task = trim($_POST["Task"]);
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
  if (empty($Charity_number_err) && empty($Name_err) && empty($Email_err) && empty($Address_err) && empty($Postcode_err) && empty($Contact_number_err) && empty($Charity_type_err) && empty($Task_err) && empty($Password_err) && empty($Password_confirm_err)) { 

    $sql = $conn->prepare("INSERT INTO charities (charityNumber, charityName, address, postcode, phoneNumber, charityType, task, minimumAge, carRequired, DBSRequired, charityEmail, charityPassword)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $Hashed_password = password_hash($Password, PASSWORD_DEFAULT);

    if (isset($_POST['Car_required'])){
        $Car_required = "Yes";
    }
    if (isset($_POST['DBS_required'])){
        $DBS_required = "Yes";
    }
    $Minimum_age = $_POST['Minimum_age'];

    $sql->bind_param("isssississss", $Charity_number, $Name, $Address, $Postcode, $Contact_number, $Charity_type, $Task, $Minimum_age, $Car_required, $DBS_required, $Email, $Hashed_password);

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

  <div class="container">
      <div id = "charity" class="jumbotron">
          <h2>Register your charity with us!</h2>
          <br>
          <form class="container" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="Name">Name: </label>
                      <input type="text" class="form-control" id="Name" name="Name">
                      <span class="help-block"><?php echo $Name_err; ?></span>
                  </div>
                  <div class="form-group">
                      <label for="Charity_number">Charity number: </label>
                      <input type="number" class="form-control" id="Charity_number" name="Charity_number">
                      <span class="help-block"><?php echo $Charity_number_err; ?></span>
                  </div>
                  <div class="form-group">
                      <label for="Email">Email: </label>
                      <input type="text" class="form-control" id="Email" name="Email">
                      <span class="help-block"><?php echo $Email; ?></span>
                  </div>
                  <div class="form-group">
                      <label for="Contact_number">Phone number: </label>
                      <input type="text" class="form-control" id="Contact_number" name="Contact_number">
                      <span class="help-block"><?php echo $Contact_number_err; ?></span>
                  </div>
                  <div class="form-group">
                      <label for="Address">Address: </label>
                      <input type="text" class="form-control" id="Address" name="Address">
                      <span class="help-block"><?php echo $Address_err; ?></span>
                  </div>
                  <div class="form-group">
                      <label for="Postcode">Postcode: </label>
                      <input type="text" class="form-control" id="Postcode" name="Postcode">
                      <span class="help-block"><?php echo $Postcode_err; ?></span>
                  </div>
                  <div class="form-group">
                      <label for="Charity_type">Service offered: </label>
                      <select class="form-control" name="Charity_type" id="Charity_type">
                          <option value="elderly people">elderly people</option>
                          <option value="education">education</option>
                          <option value="health">health</option>
                          <option value="environment">environment</option>
                          <option value="animals">animals</option>
                          <option value="international">international</option>
                          <option value="young people">young people</option>
                          <option value="homelessness">homelessness</option>
                      </select>
                      <span class="help-block"><?php echo $Charity_type_err; ?></span>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="Task">Task to be conducted: </label>
                      <textarea id="Task" name="Task" rows="4" class="form-control"></textarea>
                      <span class="help-block"><?php echo $Task_err; ?></span>
                  </div>
                  <div class="form-group">
                      <label for="Minimum_age">Minimum age required: (optional)</label>
                      <input type="number" class="form-control" id="Minimum_age" name="Minimum_age">
                      <span class="help-block"><?php echo $Minimum_age_err; ?></span>
                  </div>
                  <div class="form-group">
                      <br>
                      <label for="Car_required">Is a car required?: (optional) </label>
                      <input type="checkbox" id="Car_required" name="Car_required" value="Yes">
                      <span class="help-block"><?php echo $Car_required_err; ?></span>
                  </div>
                  <div class="form-group">
                      <br>
                      <label for="DBS_required">Is a Disclosure and Barring Service (DBS) required?: (optional) </label>
                      <input type="checkbox" id="DBS_required" name="DBS_required" value="Yes">
                      <span class="help-block"><?php echo $DBS_required_err; ?></span>
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
              </div>
          </div>
          </form>
          </div>
      </div>
  </div>
  </body>
</html>
