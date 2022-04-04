<?php 

// Destroying session and redirecting to login page
session_start();

session_unset();
          
session_destroy(); 

header("Location: login.php");
exit(); 

?>