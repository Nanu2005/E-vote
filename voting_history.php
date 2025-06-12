<?php
session_start();
include("connection.php");

// Get the winner from the session
$winner = isset($_SESSION['winner']) ? $_SESSION['winner'] : 'Unknown';

// Fetch voting history
$result = mysqli_query($connect, "SELECT * FROM voting_history ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voting History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            padding: 20px;
        }
        .history-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 1000px;
            margin: auto;
        }
        h2 {
            color: #2c3e50;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .no-data {
            text-align: center;
            color: #888;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="history-box">
        <h2>Voting History</h2>

        <p><strong>Winner: </strong><?php echo $winner; ?></p>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Winner</th>
                        <th>Voting Date</th>
                        <th>Time Limit (minutes)</th>
                        <th>Reason</th>
                        <th>Recorded At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['winner']); ?></td>
                            <td><?php echo htmlspecialchars($row['voting_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['voting_time_limit']); ?></td>
                            <td><?php echo htmlspecialchars($row['voting_reason']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">No voting history found.</div>
        <?php endif; ?>
    </div>
</body>
</html>
