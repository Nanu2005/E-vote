<?php
session_start();
include("gurii.php"); // Database connection

// Check if the user is logged in
if (!isset($_SESSION['voter_name'])) {
    header("Location: loginnn.html");
    exit();
}

// Fetch all election titles
$title_query = "SELECT DISTINCT election_title, declared_at FROM results_history ORDER BY declared_at DESC";
$title_result = mysqli_query($connect, $title_query);

$elections = [];
while ($row = mysqli_fetch_assoc($title_result)) {
    $elections[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Election History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            padding: 30px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        .election-block {
            margin-bottom: 40px;
        }
        .election-block h3 {
            color: #3498db;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background: #2980b9;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>📜 Past Election Results</h1>

    <?php foreach ($elections as $election): ?>
        <div class="election-block">
            <h3><?php echo htmlspecialchars($election['election_title']); ?> 
                <small style="font-weight:normal; font-size:14px;">(<?php echo date('d M Y, h:i A', strtotime($election['declared_at'])); ?>)</small>
            </h3>
            <table>
                <tr>
                    <th>Candidate</th>
                    <th>Votes</th>
                </tr>
                <?php
                $title = mysqli_real_escape_string($connect, $election['election_title']);
                $details_query = "SELECT candidate_name, vote_count FROM results_history WHERE election_title = '$title' ORDER BY vote_count DESC";
                $details_result = mysqli_query($connect, $details_query);
                while ($row = mysqli_fetch_assoc($details_result)) {
                    echo "<tr><td>{$row['candidate_name']}</td><td>{$row['vote_count']}</td></tr>";
                }
                ?>
            </table>
        </div>
    <?php endforeach; ?>

    <?php if (empty($elections)) echo "<p>No past elections recorded yet.</p>"; ?>
</div>

</body>
</html>
