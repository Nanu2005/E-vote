<?php
$host = 'localhost'; // or your database host
$username = 'root';  // your MySQL username
$password = '';      // your MySQL password
$dbname = 'voting';  // your database name

// Create connection
$db_connection = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$db_connection) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";
?>
