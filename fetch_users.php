<?php
include 'db_connection.php';

$voter_id = $_GET['voter_id'];

// Fetch ONE voter
$voterQuery = "SELECT * FROM users WHERE role='Voter' AND id='$voter_id' LIMIT 1";
$voterResult = mysqli_query($conn, $voterQuery);
$voter = mysqli_fetch_assoc($voterResult);

// Fetch ALL candidates
$candidatesQuery = "SELECT * FROM users WHERE role='Candidate'";
$candidatesResult = mysqli_query($conn, $candidatesQuery);

$candidates = [];
while ($row = mysqli_fetch_assoc($candidatesResult)) {
    $candidates[] = $row;
}

// Return JSON data
echo json_encode([
    "voter" => $voter,
    "candidates" => $candidates
]);
?>
