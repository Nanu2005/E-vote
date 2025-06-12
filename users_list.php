<?php
include("connection.php");

// Delete logic (if redirected back here after deletion)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_user'])) {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $role = mysqli_real_escape_string($connect, $_POST['role']);

    // Delete the user from the reg_user table
    mysqli_query($connect, "DELETE FROM reg_user WHERE name='$name' AND role='$role'");

    // If the removed user was a voter, also delete their votes
    if ($role == 'Voter') {
        mysqli_query($connect, "DELETE FROM votes WHERE voter_name='$name'");
    }

    // Redirect back to the users list page
    header("Location: users_list.php");
    exit();
}

// Fetch voters and candidates
$voters = [];
$voter_result = mysqli_query($connect, "SELECT name FROM reg_user WHERE role='Voter'");
while ($row = mysqli_fetch_assoc($voter_result)) {
    $voters[] = $row['name'];
}

$candidates = [];
$candidate_result = mysqli_query($connect, "SELECT name FROM reg_user WHERE role='Candidate'");
while ($row = mysqli_fetch_assoc($candidate_result)) {
    $candidates[] = $row['name'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users List</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; margin: 0; padding: 20px; }
        .container { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); max-width: 1000px; margin: auto; }
        h1 { text-align: center; color: #2c3e50; }
        .role-section { margin-bottom: 30px; }
        .role-section h3 { color: #3498db; }
        ul { list-style-type: none; padding: 0; }
        li { display: flex; justify-content: space-between; align-items: center; padding: 8px; background: #ecf0f1; margin-bottom: 5px; border-radius: 5px; }
        form { margin: 0; }
        button { background-color: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #c0392b; }
    </style>
</head>
<body>

<div class="container">
    <h1>Users List</h1>

    <!-- Voters List -->
    <div class="role-section">
        <h3>Voters</h3>
        <p><strong>Total Voters:</strong> <?php echo count($voters); ?></p>
        <ul>
            <?php foreach ($voters as $voter): ?>
                <li>
                    <?php echo $voter; ?>
                    <form method="POST" action="users_list.php" onsubmit="return confirm('Are you sure you want to remove this voter?');">
                        <input type="hidden" name="name" value="<?php echo $voter; ?>">
                        <input type="hidden" name="role" value="Voter">
                        <button type="submit" name="remove_user">Remove</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Candidates List -->
    <div class="role-section">
        <h3>Candidates</h3>
        <p><strong>Total Candidates:</strong> <?php echo count($candidates); ?></p>
        <ul>
            <?php foreach ($candidates as $candidate): ?>
                <li>
                    <?php echo $candidate; ?>
                    <form method="POST" action="users_list.php" onsubmit="return confirm('Are you sure you want to remove this candidate?');">
                        <input type="hidden" name="name" value="<?php echo $candidate; ?>">
                        <input type="hidden" name="role" value="Candidate">
                        <button type="submit" name="remove_user">Remove</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

</body>
</html>
