<?php
$conn_server    = "localhost";
$conn_username  = "root";
$conn_password  = "";
$conn_db        = "db_clientaddressbook";

// Create connection
$conn = mysqli_connect($conn_server, $conn_username, $conn_password, $conn_db);

// Check connection
if(!$conn) {
    die("<div>Database connection succeeded!<br>".mysqli_connect_error()."</div>");
}   
?> 