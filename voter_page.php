<?php
session_start();
if ($_SESSION['role'] !== 'Voter') {
    header('Location: login.html'); // Redirect to login if the user is not a Voter
    exit();
}

// Voter-specific content here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voter Page</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['voter_name']; ?> (Voter)</h1>
    <p>This is the Voter page where you can participate in voting.</p>
</body>
</html>
