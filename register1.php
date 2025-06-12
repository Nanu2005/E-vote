<?php
include("gurii.php"); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = mysqli_real_escape_string($connect, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($connect, $_POST['lastname']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    
    // Encrypt password using bcrypt
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $check_email = mysqli_query($connect, "SELECT * FROM user WHERE email='$email'");
    if (mysqli_num_rows($check_email) > 0) {
        echo "<script>alert('Email already registered!'); window.location.href = 'loginnn.html';</script>";
        exit();
    }

    // Insert user data into the database
    $query = "INSERT INTO user (firstname, lastname, email, password) VALUES ('$firstname', '$lastname', '$email', '$hashed_password')";
    
    if (mysqli_query($connect, $query)) {
        echo "<script>alert('Registration successful!'); window.location.href = 'loginnn.html';</script>";
    } else {
        echo "<script>alert('Registration failed. Please try again!'); window.location.href = 'loginnn.html';</script>";
    }
}
?>
