<?php
include("connection.php");

// Fetch live voting data
$votes_query = "SELECT candidate_name, votes FROM candidates";
$votes_result = mysqli_query($connect, $votes_query);
$candidates = [];

if ($votes_result) {
    while ($row = mysqli_fetch_assoc($votes_result)) {
        $candidates[] = [
            'name' => $row['candidate_name'],
            'votes' => $row['votes']
        ];
    }
}

// Return data as JSON
echo json_encode($candidates);
?>
