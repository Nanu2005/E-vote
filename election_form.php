<?php
session_start();
include("gurii.php"); // Ensure you have a database connection file

// Fetch the current election title and reason if they exist
$title_query = mysqli_query($connect, "SELECT title, reason FROM election_title ORDER BY created_at DESC LIMIT 1");
$current_title = mysqli_fetch_assoc($title_query);

// Check if there's any session message to display
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';

// Clear session messages after they are displayed
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Election Title Form</title>
  <link rel="stylesheet" href="style.css"> <!-- Your style file if needed -->
</head>
<body>

  <div class="container">
    <h1>Election Title</h1>

    <!-- Display success or error messages -->
    <?php if ($success_message): ?>
      <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?>
    
    <?php if ($error_message): ?>
      <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <!-- Form to add or update election title and reason -->
    <form action="title_action.php" method="POST">
      <div class="form-group">
        <label for="title">Election Title</label>
        <input type="text" id="title" name="title" value="<?php echo isset($current_title['title']) ? $current_title['title'] : ''; ?>" required>
      </div>
      
      <div class="form-group">
        <label for="reason">Reason for the Vote</label>
        <textarea id="reason" name="reason" required><?php echo isset($current_title['reason']) ? $current_title['reason'] : ''; ?></textarea>
      </div>
      
      <button type="submit">Save</button>
    </form>
  </div>

</body>
</html>
