<?php
include("connection.php"); // Include your DB connection

// Fetch the history of elections from the `results_history` table
$query = "SELECT * FROM results_history ORDER BY declared_at DESC";
$result = mysqli_query($connect, $query);

// Check if there are any past elections
if (mysqli_num_rows($result) == 0) {
    $message = "No past elections recorded yet.";
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
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .history-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 5px 15px rgba(0,0,0,0.2);
            width: 600px;
        }
        .history-box h1 {
            color: #28a745;
            text-align: center;
        }
        .history-list {
            margin-top: 30px;
            text-align: left;
        }
        .history-list table {
            width: 100%;
            border-collapse: collapse;
        }
        .history-list th, .history-list td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .history-list th {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>

<div class="history-box">
    <h1>🏆 Election History</h1>

    <?php if (isset($message)) { ?>
        <p style="color: #e74c3c; text-align: center;"><?php echo $message; ?></p>
    <?php } else { ?>
        <div class="history-list">
            <h3>Past Elections</h3>
            <table>
                <tr>
                    <th>Election Title</th>
                    <th>Candidate</th>
                    <th>Vote Count</th>
                    <th>Date Declared</th>
                </tr>
                <?php
                // Fetch and display the election history
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['election_title']}</td>
                            <td>{$row['candidate_name']}</td>
                            <td>{$row['vote_count']}</td>
                            <td>{$row['declared_at']}</td>
                          </tr>";
                }
                ?>
            </table>
        </div>
    <?php } ?>
</div>

</body>
</html>
