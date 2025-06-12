<?php
include("connection.php");

// Add new position
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $title = mysqli_real_escape_string($connect, $_POST['title']);
    $description = mysqli_real_escape_string($connect, $_POST['description']);
    mysqli_query($connect, "INSERT INTO ballot_positions (position_name, description) VALUES ('$title', '$description')");
}

// Delete position
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($connect, "DELETE FROM ballot_positions WHERE id = $id");
}

// Save all edits
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_all']) && isset($_POST['id']) && is_array($_POST['id'])) {
    foreach ($_POST['id'] as $index => $id) {
        $title = mysqli_real_escape_string($connect, $_POST['title'][$index]);
        $description = mysqli_real_escape_string($connect, $_POST['description'][$index]);
        mysqli_query($connect, "UPDATE ballot_positions SET position_name='$title', description='$description' WHERE id=$id");
    }
}

// Fetch all positions
$positions = mysqli_query($connect, "SELECT * FROM ballot_positions");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ballot Positions</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        h2 { text-align: center; }
        form.add-form, form.save-form { max-width: 500px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; }
        input[type="text"], textarea {
            width: 50%; padding: 6px 10px; font-size: 14px; margin-bottom: 10px;
            border: 1px solid #ccc; border-radius: 4px;
        }
        textarea { resize: vertical; height: 60px; }
        button {
            padding: 8px 15px; background: #2980b9; color: white;
            border: none; border-radius: 4px; cursor: pointer;
        }
        table {
            width: 90%; margin: 20px auto; border-collapse: collapse; background: white;
        }
        th, td {
            padding: 10px; border: 1px solid #ccc; text-align: center;
        }
        a.delete-link {
            color: red; text-decoration: none;
        }
    </style>
</head>
<body>

<h2>Manage Ballot Positions</h2>

<!-- Add New Position Form -->
<form class="add-form" method="POST">
    <input type="text" name="title" required placeholder="Position Title">
    <textarea name="description" required placeholder="Position Description"></textarea>
    <button type="submit" name="add">Add Position</button>
</form>

<!-- Edit/Save Table -->
<form class="save-form" method="POST">
    <table>
        <tr>
            <th>ID</th>
            <th>Position</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($positions)) { ?>
            <tr>
                <td>
                    <?php echo $row['id']; ?>
                    <input type="hidden" name="id[]" value="<?php echo $row['id']; ?>">
                </td>
                <td><input type="text" name="title[]" value="<?php echo htmlspecialchars($row['position_name']); ?>" required></td>
                <td><input type="text" name="description[]" value="<?php echo htmlspecialchars($row['description']); ?>" required></td>
                <td>
                    <a class="delete-link" href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure to delete this position?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
    <div style="text-align: center;">
        <button type="submit" name="save_all">Save All</button>
    </div>
</form>

</body>
</html>
