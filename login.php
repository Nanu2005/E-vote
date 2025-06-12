<?php
include("gurii.php"); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    // Check user credentials
    $query = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify the hashed password
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['firstname'] = $user['firstname'];
            
            echo "<script>alert('Login successful!'); window.location.href = 'verify_code.html';</script>";
        } else {
            echo "<script>alert('Incorrect password. Try again!'); window.location.href = 'loginnn.html';</script>";
        }
    } else {
        echo "<script>alert('No account found with this email. Register first!'); window.location.href = 'loginnn.html';</script>";
    }
}
?>
