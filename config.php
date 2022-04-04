<?php
    $user = "mamp";
    $pass = "root";
    $host = "localhost";
    $dbdb = "bathhack";
    
$conn = new mysqli($host, $user, $pass, $dbdb);
   if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>