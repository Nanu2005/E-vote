<?php
session_start();
include("gurii.php"); // Ensure this connects to your DB

$message = ''; // Initialize message variable

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($connect, $_POST['title']);
    $reason = mysqli_real_escape_string($connect, $_POST['reason']);

    $check = mysqli_query($connect, "SELECT * FROM election_title LIMIT 1");

    if (mysqli_num_rows($check) > 0) {
        $query = "UPDATE election_title SET title='$title', reason='$reason', created_at=NOW()";
        $message = "Election title updated successfully!";
    } else {
        $query = "INSERT INTO election_title (title, reason) VALUES ('$title', '$reason')";
        $message = "Election title added successfully!";
    }

    if (mysqli_query($connect, $query)) {
        $_SESSION['success_message'] = $message;
    } else {
        $_SESSION['error_message'] = "Error: " . mysqli_error($connect);
    }
}

// Fetch current election title
$title_result = mysqli_query($connect, "SELECT * FROM election_title ORDER BY created_at DESC LIMIT 1");
$current_title = mysqli_fetch_assoc($title_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Set Election Title</title>
  <link rel="stylesheet" href="title.css">
  <style>
    .container { max-width: 800px; margin: auto; padding: 30px; background: #f0f0f0; border-radius: 8px; }
    label { display: block; margin-top: 15px; font-weight: bold; }
    input[type="text"], textarea { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
    button { margin-top: 20px; padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; }
    h2 { text-align: center; }
    .message { font-weight: bold; margin-top: 20px; color: green; }
    .error { color: red; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Set Election Title</h2>
    <form method="post" action="title.php">
      <label for="title">Election Title:</label>
      <input type="text" id="title" name="title" required placeholder="Enter election title..." value="<?php echo isset($current_title['title']) ? $current_title['title'] : ''; ?>">

      <label for="reason">Reason for Election:</label>
      <textarea id="reason" name="reason" required placeholder="Explain the reason..."><?php echo isset($current_title['reason']) ? $current_title['reason'] : ''; ?></textarea>

      <button type="submit">Save Election Title</button>
    </form>

    <!-- Display success or error message -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <p class="message"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></p>
    <?php elseif (isset($_SESSION['error_message'])): ?>
        <p class="message error"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></p>
    <?php endif; ?>

    <!-- Display Election Title -->
    <?php if ($current_title): ?>
      <div class="ballot-list">
        <h3>Current Election Title:</h3>
        <p><strong>Title:</strong> <?php echo htmlspecialchars($current_title['title']); ?></p>
        <p><strong>Reason:</strong> <?php echo htmlspecialchars($current_title['reason']); ?></p>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
