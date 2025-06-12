<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("gurii.php"); // Database connection

// Ensure user is logged in
if (!isset($_SESSION['voter_name'])) {
    header("Location: regii.html");
    exit();
}

// Fetch voter details
$voter_name = $_SESSION['voter_name'];
$voter_query = mysqli_query($connect, "SELECT * FROM reg_user WHERE name='$voter_name'");
$voter = mysqli_fetch_assoc($voter_query);

// Handle voter not found
if (!$voter) {
    session_destroy();
    header("Location: regii.html");
    exit();
}

// User role and voted candidate
$user_role = $voter['role'];
$voted_candidate = isset($voter['voted_candidate']) ? $voter['voted_candidate'] : 'No Vote';

// Fetch candidates
$candidates_query = mysqli_query($connect, "SELECT * FROM reg_user WHERE role='Candidate'");

// Fetch election title, reason
$title_query = mysqli_query($connect, "SELECT title, reason FROM election_title ORDER BY created_at DESC LIMIT 1");
$title_data = mysqli_fetch_assoc($title_query);
$election_title = $title_data['title'] ?? 'No Title Set';
$election_reason = $title_data['reason'] ?? 'No Reason Set';

// Handle Voting
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vote'])) {
    $selected_candidate = $_POST['candidate_name'];

    if ($voted_candidate == 'No Vote') {
        mysqli_query($connect, "UPDATE reg_user SET voted_candidate='$selected_candidate' WHERE name='$voter_name'");
        mysqli_query($connect, "INSERT INTO votes (voter_name, candidate_name) VALUES ('$voter_name', '$selected_candidate')");

        // Redirect to refresh session data
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('You have already voted!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Online Voting System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .dashboard-container {
            display: flex;
            width: 90%;
            max-width: 1000px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .profile {
            width: 30%;
            background: #007BFF;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid white;
        }
        .profile h2 {
            margin: 10px 0;
        }
        .candidates {
            width: 70%;
            background: white;
            padding: 20px;
        }
        .candidates h2 {
            text-align: center;
            color: #333;
        }
        .candidate-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            justify-items: center;
            padding: 10px;
        }
        .candidate {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            width: 100%;
            max-width: 150px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }
        .candidate img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
        }
        button {
            margin-top: 10px;
            padding: 8px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .vote-count {
            font-size: 14px;
            color: #555;
            margin-top: 5px;
        }
        .election-info {
            background-color: #f1f1f1;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .election-info h3 {
            margin: 0 0 10px;
            color: #333;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <!-- Voter Profile -->
    <div class="profile">
        <img src="uploads_images/<?php echo htmlspecialchars($voter['photo']); ?>" alt="Voter Photo">
        <h2><?php echo htmlspecialchars($voter['name']); ?></h2>
        <p><strong>Mobile:</strong> <?php echo htmlspecialchars($voter['mobile']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($voter['address']); ?></p>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($voter['role']); ?></p>
        <p><strong>Vote Status:</strong> <?php echo ($voted_candidate == 'No Vote') ? 'No Vote' : 'Voted'; ?></p>
        <?php if ($voted_candidate != 'No Vote') { ?>
            <p><strong>You voted for:</strong> <?php echo htmlspecialchars($voted_candidate); ?></p>
        <?php } ?>
    </div>

    <!-- Candidates Section -->
    <div class="candidates">
        <div class="election-info">
            <h3>Election Title</h3>
            <p><strong>Title:</strong> <?php echo htmlspecialchars($election_title); ?></p>
            <p><strong>Reason:</strong> <?php echo htmlspecialchars($election_reason); ?></p>
        </div>

        <?php if ($user_role == 'Voter') { ?>
            <h2>Vote for a Candidate</h2>
            <div class="candidate-list">
                <?php while ($candidate = mysqli_fetch_assoc($candidates_query)) { ?>
                    <div class="candidate">
                        <img src="uploads_images/<?php echo htmlspecialchars($candidate['photo']); ?>" alt="Candidate Photo">
                        <h3><?php echo htmlspecialchars($candidate['name']); ?></h3>
                        <?php if ($voted_candidate == 'No Vote') { ?>
                            <form action="" method="POST">
                                <input type="hidden" name="candidate_name" value="<?php echo htmlspecialchars($candidate['name']); ?>">
                                <button type="submit" name="vote">Vote</button>
                            </form>
                        <?php } else { ?>
                            <p style="color: green;">Vote Recorded</p>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
