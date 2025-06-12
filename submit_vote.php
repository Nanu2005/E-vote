<?php
session_start();
include("gurii.php"); // Database connection file

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];
$candidate_id = $_POST['candidate_id'];

// Check if user has already voted
$check_query = "SELECT * FROM votes WHERE user_id = ?";
$stmt = mysqli_prepare($connect, $check_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo "You have already voted!";
    exit();
}

// Insert vote securely
$insert_query = "INSERT INTO votes (user_id, candidate_id) VALUES (?, ?)";
$stmt = mysqli_prepare($connect, $insert_query);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $candidate_id);
if (mysqli_stmt_execute($stmt)) {
    echo "Vote submitted successfully!";
} else {
    echo "Error submitting vote.";
}
?>
