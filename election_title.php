<?php
include("connection.php");

// Start or Stop Voting
if (isset($_POST['toggle_voting'])) {
    // Check if the voting date and time limit are set
    $status_result = mysqli_query($connect, "SELECT status, time_limit, voting_date FROM voting_status WHERE id = 1");
    $status_row = mysqli_fetch_assoc($status_result);
    $voting_time_limit = $status_row['time_limit'];
    $voting_date = $status_row['voting_date'];

    // Only allow "Start Voting" if time limit and voting date are set
    if ($voting_time_limit > 0 && !empty($voting_date)) {
        $new_status = $_POST['toggle_voting'] === 'Start Voting' ? 'Open' : 'Closed';
        mysqli_query($connect, "UPDATE voting_status SET status='$new_status' WHERE id=1");
    } else {
        $error_message = "Please set the voting time limit and date before starting the voting.";
    }
}

// Set Voting Time Limit (Hours and Minutes combined) and Date
if (isset($_POST['voting_time']) && isset($_POST['voting_date'])) {
    $voting_time = $_POST['voting_time'];
    $voting_hours = 0;
    $voting_minutes = 0;

    // Regular expression to match the hours and minutes format
    if (preg_match('/(\d+)\s*hours?\s*(\d+)\s*minutes?/', $voting_time, $matches)) {
        $voting_hours = (int) $matches[1];
        $voting_minutes = (int) $matches[2];
    } elseif (preg_match('/(\d+)\s*hours?/', $voting_time, $matches)) {
        $voting_hours = (int) $matches[1];
    } elseif (preg_match('/(\d+)\s*minutes?/', $voting_time, $matches)) {
        $voting_minutes = (int) $matches[1];
    }

    $total_time_limit = ($voting_hours * 60) + $voting_minutes;
    $voting_date = $_POST['voting_date'];

    // Update database
    if ($total_time_limit > 0 && !empty($voting_date)) {
        mysqli_query($connect, "UPDATE voting_status SET time_limit=$total_time_limit, voting_date='$voting_date' WHERE id=1");
        $time_message = "Voting time limit set to: $voting_hours hours and $voting_minutes minutes on $voting_date";
    } else {
        $time_message = "Invalid time format or date entered. Please try again.";
    }
}

// Fetch current status, time, and date
$status_result = mysqli_query($connect, "SELECT status, time_limit, voting_date FROM voting_status WHERE id = 1");
$status_row = mysqli_fetch_assoc($status_result);
$status = $status_row['status'] ?? "Closed";
$voting_time_limit = $status_row['time_limit'] ?? "Not set";
$voting_date = $status_row['voting_date'] ?? "Not set";

// Fetch voters and candidates
$voters = [];
$voter_query = mysqli_query($connect, "SELECT name FROM reg_user WHERE role='Voter'");
while ($row = mysqli_fetch_assoc($voter_query)) {
    $voters[] = $row['name'];
}

$candidates = [];
$candidate_query = mysqli_query($connect, "SELECT name FROM reg_user WHERE role='Candidate'");
while ($row = mysqli_fetch_assoc($candidate_query)) {
    $candidates[] = $row['name'];
}

// Admin code logic
if (isset($_POST['admin_code'])) {
    $admin_code = htmlspecialchars($_POST['admin_code']);
    $message = "Admin code saved: $admin_code";
}

// Show users when button clicked
$show_users = false;
if (isset($_POST['show_users'])) {
    $show_users = true;
}

// Show Voting History if Button Clicked
if (isset($_POST['show_history'])) {
    // Fetch the latest voting history
    $history_query = mysqli_query($connect, "SELECT * FROM voting_history ORDER BY created_at DESC LIMIT 1");
    $history_row = mysqli_fetch_assoc($history_query);
    $history_data = null;
    if ($history_row) {
        $history_data = $history_row;
    }
}

// Insert history when voting is closed
if ($status == 'Closed' && isset($_POST['toggle_voting']) && $_POST['toggle_voting'] === 'Stop Voting') {
    // Assume the winner is calculated based on votes (you need to replace this logic with actual vote counting)
    $winner = "Candidate A";  // This should be dynamically calculated based on vote count
    $voting_reason = "Election for student council president";  // The reason for the election
    $election_title = "Student Council Election 2025";  // The title of the election

    // Insert the history into the database
    mysqli_query($connect, "INSERT INTO voting_history (winner, voting_date, voting_time_limit, voting_reason, election_title)
                            VALUES ('$winner', '$voting_date', $voting_time_limit, '$voting_reason', '$election_title')");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f0f2f5; }
        .dashboard { display: flex; min-height: 100vh; }
        .sidebar {
            width: 250px; background: #2c3e50; color: white;
            padding: 20px; box-sizing: border-box;
        }
        .sidebar h2 { text-align: center; }
        .sidebar a {
            color: white; text-decoration: none; display: block;
            padding: 10px; margin: 10px 0; background: #34495e;
            border-radius: 5px;
        }
        .main { flex-grow: 1; padding: 30px; }
        h1 { color: #2c3e50; }
        .status-box, .form-box, .roles-box, .history-box {
            background: white; padding: 20px; border-radius: 10px;
            margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group { margin: 15px 0; }
        input[type="number"], input[type="text"], input[type="date"] {
            width: 100%; padding: 10px; border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 20px; background: #3498db; color: white;
            border: none; border-radius: 5px; cursor: pointer;
        }
        ul { padding-left: 20px; }
    </style>
</head>
<body>
<div class="dashboard">
    <div class="sidebar">
        <h2>Voting System</h2>
        <a href="user_interface.php">Dashboard</a>
        <a href="results.php">Results</a> <!-- This opens the results in a new tab -->
        <a href="title.html">Election Title</a>
    </div>
    <div class="main">
        <h1>Admin Dashboard</h1>

        <div class="status-box">
            <h3>Voting Status</h3>
            <p>Status: <strong><?php echo $status; ?></strong></p>
            <form method="post">
                <?php if ($voting_time_limit <= 0 || empty($voting_date)): ?>
                    <p style="color: red;">Please set the voting time limit and date before starting the voting.</p>
                <?php else: ?>
                    <button name="toggle_voting" value="<?php echo ($status == 'Open') ? 'Stop Voting' : 'Start Voting'; ?>">
                        <?php echo ($status == 'Open') ? 'Stop Voting' : 'Start Voting'; ?>
                    </button>
                <?php endif; ?>
            </form>

            <p style="margin-top:20px;">Current Time Limit: 
                <strong><?php echo is_numeric($voting_time_limit) ? $voting_time_limit . " minutes" : "Not set"; ?></strong>
            </p>
            <p>Current Date: <strong><?php echo $voting_date; ?></strong></p>
            <form method="post">
                <div class="form-group">
                    <input type="text" name="voting_time" placeholder="Enter time (e.g., 2 hours 30 minutes)" required>
                </div>
                <div class="form-group">
                    <input type="date" name="voting_date" required>
                </div>
                <button type="submit">Set Time Limit and Date</button>
            </form>
            <?php if (isset($time_message)) echo "<p style='color: green;'>$time_message</p>"; ?>
        </div>

        <div class="roles-box">
            <h3>Users</h3>
            <form method="post">
                <button name="show_users" value="1">Show Voters and Candidates</button>
            </form>

            <?php if ($show_users): ?>
                <p><strong>Total Voters:</strong> <?php echo count($voters); ?></p>
                <ul>
                    <?php foreach ($voters as $voter) echo "<li>$voter</li>"; ?>
                </ul>

                <p><strong>Total Candidates:</strong> <?php echo count($candidates); ?></p>
                <ul>
                    <?php foreach ($candidates as $candidate) echo "<li>$candidate</li>"; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="history-box">
            <h3>Voting History</h3>
            <form method="post">
                <button name="show_history" value="1">Show Voting History</button>
            </form>

            <?php if (isset($history_data)): ?>
                <p><strong>Election Title:</strong> <?php echo $history_data['election_title']; ?></p>
                <p><strong>Winner:</strong> <?php echo $history_data['winner']; ?></p>
                <p><strong>Voting Date:</strong> <?php echo $history_data['voting_date']; ?></p>
                <p><strong>Time Limit:</strong> <?php echo $history_data['voting_time_limit']; ?> minutes</p>
                <p><strong>Reason for Voting:</strong> <?php echo $history_data['voting_reason']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form-box">
            <h3>Admin Code</h3>
            <form method="post">
                <input type="text" name="admin_code" placeholder="Enter admin code" required>
                <button type="submit">Save Admin Code</button>
            </form>
            <?php if (isset($message)) echo "<p style='color: green;'>$message</p>"; ?>
        </div>
    </div>
</div>
</body>
</html>
