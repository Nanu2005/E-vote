<?php
session_start();
include("gurii.php");

if (!isset($_SESSION['voter_name'])) {
    header("Location: loginnn.html");
    exit();
}

$voter_name = $_SESSION['voter_name'];
$candidate_id = $_POST['candidate_id'];

// Ensure voter hasn't voted before
$check_vote = mysqli_query($connect, "SELECT * FROM reg_user WHERE name='$voter_name' AND status=1");
if (mysqli_num_rows($check_vote) > 0) {
    echo "<script>
            alert('You have already voted!');
            window.location.href = 'dashboard.php';
          </script>";
    exit();
}

// Cast vote
$update_candidate = mysqli_query($connect, "UPDATE reg_user SET votes = votes + 1 WHERE id='$candidate_id'");
$update_voter = mysqli_query($connect, "UPDATE reg_user SET status = 1 WHERE name='$voter_name'");

if ($update_candidate && $update_voter) {
    echo "<script>
            alert('Vote cast successfully!');
            window.location.href = 'dashboard.php';
          </script>";
} else {
    echo "<script>
            alert('Error casting vote. Try again.');
            window.location.href = 'dashboard.php';
          </script>";
}
?>
