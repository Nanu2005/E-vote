<?php
session_start();
include("connection.php");

// Start Voting
if (isset($_POST['set_time'])) {
    $hours = intval($_POST['hours']);
    $minutes = intval($_POST['minutes']);
    $total_minutes = ($hours * 60) + $minutes;

    if (mysqli_query($connect, "UPDATE voting_status SET time_limit = $total_minutes WHERE id = 1")) {
        mysqli_query($connect, "UPDATE voting_status SET status = 'Open', voting_date = NOW() WHERE id = 1");
        echo "<script>alert('Voting started with a time limit of $total_minutes minutes.');</script>";
    }
}

// Stop Voting
if (isset($_POST['stop_voting'])) {
    if (mysqli_query($connect, "UPDATE voting_status SET status = 'Closed' WHERE id = 1")) {
        echo "<script>alert('Voting has been stopped!');</script>";
    }
}

// Fetch status
$status_result = mysqli_query($connect, "SELECT status, time_limit FROM voting_status WHERE id = 1");
$status_row = mysqli_fetch_assoc($status_result);
$current_status = $status_row['status'] ?? 'Closed';
$current_limit = $status_row['time_limit'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Interface</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f2f2f2; }
        .status-box {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .status-box h3 { margin-top: 0; }
        label, input { display: block; margin-bottom: 10px; }
        button {
            background: #3498db;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="status-box">
        <h3>Voting Control (Admin)</h3>
        <p>Status: <strong><?php echo $current_status; ?></strong></p>

        <?php if ($current_status == 'Closed'): ?>
            <form method="post">
                <label>Hours:</label>
                <input type="number" name="hours" min="0" required>
                <label>Minutes:</label>
                <input type="number" name="minutes" min="0" max="59" required>
                <button type="submit" name="set_time">Set Time & Start Voting</button>
            </form>
        <?php else: ?>
            <form method="post">
                <button type="submit" name="stop_voting">Stop Voting</button>
            </form>
        <?php endif; ?>

        <p>Time Limit: <strong><?php echo $current_limit . " minutes"; ?></strong></p>
    </div>
</body>
</html>
