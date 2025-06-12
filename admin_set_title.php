<?php
session_start();
include("gurii.php"); // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($connect, $_POST['title']);
    $reason = mysqli_real_escape_string($connect, $_POST['reason']);

    // Check if a title already exists
    $check = mysqli_query($connect, "SELECT * FROM election_title LIMIT 1");

    if (mysqli_num_rows($check) > 0) {
        // Update existing title
        $query = "UPDATE election_title SET title='$title', reason='$reason', created_at=NOW()";
    } else {
        // Insert new title
        $query = "INSERT INTO election_title (title, reason) VALUES ('$title', '$reason')";
    }

    if (mysqli_query($connect, $query)) {
        echo "<script>
                alert('Election title updated successfully');
                window.location.href = 'admin_dashboard.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Set Election Title</title>
</head>
<body>
    <h2>Set Election Title</h2>
    <form method="post">
        <label>Election Title:</label>
        <input type="text" name="title" required>
        <br><br>
        <label>Reason for Election:</label>
        <textarea name="reason" required></textarea>
        <br><br>
        <button type="submit">Save Election Title</button>
    </form>
</body>
</html>
