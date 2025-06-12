<?php
session_start();
if ($_SESSION['role'] !== 'Candidate') {
    header('Location: login.html'); // Redirect to login if the user is not a Candidate
    exit();
}

// Candidate-specific content here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Candidate Page</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['voter_name']; ?> (Candidate)</h1>
    <p>This is the Candidate page where you can manage your campaign.</p>
</body>
</html>
