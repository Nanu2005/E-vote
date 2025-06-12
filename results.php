<?php
session_start();
include("gurii.php"); // Database connection

// Check if the user is logged in
if (!isset($_SESSION['voter_name'])) {
    header("Location: loginnn.html");
    exit();
}

// Fetch vote counts ONLY if:
// - Candidate is in reg_user as 'Candidate'
// - Voter is in reg_user as 'Voter'
$query = "SELECT v.candidate_name, COUNT(*) as vote_count
          FROM votes v
          JOIN reg_user r1 ON v.candidate_name = r1.name AND r1.role = 'Candidate'
          JOIN reg_user r2 ON v.voter_name = r2.name AND r2.role = 'Voter'
          GROUP BY v.candidate_name
          ORDER BY vote_count DESC";

$result = mysqli_query($connect, $query);

// Get all vote counts
$candidate_results = [];
while ($row = mysqli_fetch_assoc($result)) {
    $candidate_results[] = $row;
}

// Determine winner
$winner = count($candidate_results) > 0 ? $candidate_results[0] : null;

// Prevent browser from caching this page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voting Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .result-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0,0,0,0.2);
            text-align: center;
            width: 400px;
        }
        .result-box h1 {
            color: #28a745;
        }
        .winner-info {
            margin-top: 20px;
            font-size: 20px;
        }
        .vote-list {
            margin-top: 30px;
            text-align: left;
        }
        .vote-list table {
            width: 100%;
            border-collapse: collapse;
        }
        .vote-list th, .vote-list td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .vote-list th {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>

<div class="result-box">
    <h1>🗳️ Voting Result</h1>
    
    <?php if ($winner) { ?>
        <div class="winner-info">
            <strong>🏆 Winner:</strong> <?php echo htmlspecialchars($winner['candidate_name']); ?><br>
            <strong>Total Votes:</strong> <?php echo $winner['vote_count']; ?>
        </div>
    <?php } else { ?>
        <p>No valid votes recorded yet.</p>
    <?php } ?>

    <div class="vote-list">
        <h3>All Candidates</h3>
        <table>
            <tr>
                <th>Candidate</th>
                <th>Votes</th>
            </tr>
            <?php foreach ($candidate_results as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['candidate_name']); ?></td>
                    <td><?php echo $row['vote_count']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

</body>
</html>
