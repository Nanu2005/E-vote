<?php
include("connection.php");

// Fetch all positions from the database
$positions_query = mysqli_query($connect, "SELECT * FROM positions");
$positions = mysqli_fetch_all($positions_query, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Positions - Voting System</title>
  <link rel="stylesheet" href="user interface.css">
  <style>
    body { font-family: 'Segoe UI', sans-serif; background-color: #f8f9fa; }
    .container { max-width: 1000px; margin: 0 auto; padding: 40px; }
    h1 { text-align: center; }
    .position-list { list-style-type: none; padding: 0; }
    .position-item { padding: 10px 15px; background-color: white; margin-bottom: 15px; border-radius: 5px; box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1); }
  </style>
</head>
<body>
  <div class="container">
    <h1>Positions Available</h1>
    <ul class="position-list">
      <?php foreach ($positions as $position): ?>
        <li class="position-item">
          <h3><?php echo htmlspecialchars($position['position_name']); ?></h3>
          <p><?php echo htmlspecialchars($position['description']); ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</body>
</html>
