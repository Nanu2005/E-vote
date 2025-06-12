<?php
$connect = mysqli_connect("localhost", "root", "root", "Online_voting");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}
?>