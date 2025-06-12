<?php
include("connection.php");
session_start();

// Save Admin Code
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['admin_code'])) {
    $admin_code = mysqli_real_escape_string($connect, $_POST['admin_code']);
    $query = "INSERT INTO admin_codes (code) VALUES ('$admin_code')";
    $message = mysqli_query($connect, $query)
        ? "Code $admin_code saved successfully!"
        : "Error: " . mysqli_error($connect);
}

// Start Voting
if (isset($_POST['start_voting'])) {
    if (mysqli_query($connect, "UPDATE voting_status SET status = 'Open', voting_date = NOW() WHERE id = 1")) {
        $message = "Voting has started!";
    } else {
        $message = "Error starting voting: " . mysqli_error($connect);
    }
}

// Stop Voting
if (isset($_POST['stop_voting'])) {
    if (mysqli_query($connect, "UPDATE voting_status SET status = 'Closed' WHERE id = 1")) {
        $message = "Voting has been stopped!";
    } else {
        $message = "Error stopping voting: " . mysqli_error($connect);
    }
}

// Current Status
$status_result = mysqli_query($connect, "SELECT status FROM voting_status WHERE id = 1");
$status_row = mysqli_fetch_assoc($status_result);
$status = $status_row['status'] ?? 'Closed';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f0f2f5; }
        .dashboard { display: flex; min-height: 100vh; }
        .sidebar {
            width: 250px; background: #2c3e50; color: white;
            padding: 20px;
        }
        .sidebar h2 { text-align: center; }
        .sidebar a {
            color: white; text-decoration: none; display: block;
            padding: 10px; margin: 10px 0; background: #34495e;
            border-radius: 5px;
        }
        .main { flex-grow: 1; padding: 30px; }
        h1 { color: #2c3e50; }

        .form-section, .roles-box {
            background: white; padding: 20px; border-radius: 10px;
            margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 6px; color: #333; }
        .form-group input {
            width: 100%; padding: 10px;
            border: 1px solid #ccc; border-radius: 6px;
        }
        .submit-btn {
            padding: 12px 20px;
            background-color: #3498db;
            color: white; border: none;
            border-radius: 6px; cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #2980b9;
        }

        .form-message.success { color: green; }
        .form-message.error { color: red; }
    </style>
</head>
<body>
<div class="dashboard">
    <div class="sidebar">
        <h2>Voting System</h2>
        <a href="user_interface.php">Dashboard</a>
        <a href="results.php">Results</a>
        <a href="title.html">Election Title</a>
    </div>

    <div class="main">
        <h1>Admin Dashboard</h1>

        <?php if (isset($message)): ?>
            <p class='form-message success'><?php echo $message; ?></p>
        <?php endif; ?>

        <div class="form-section">
            <h3>Set Admin Code</h3>
            <form method="post">
                <div class="form-group">
                    <label for="admin_code">Admin Code (4-digit):</label>
                    <input type="text" name="admin_code" maxlength="4" required>
                </div>
                <button type="submit" class="submit-btn">Save Code</button>
            </form>
        </div>

        
        <div class="roles-box">
            <h3>View All Users</h3>
            <form method="get" action="users_list.php" target="_blank">
                <button type="submit" class="submit-btn">Show Voters & Candidates</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
