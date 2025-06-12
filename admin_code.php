<?php
session_start(); // Start the session to store messages.

include("connection.php"); // ✅ Make sure this file defines $connect

$message = ''; // Initialize message variable to avoid undefined variable errors.
$message_class = ''; // Initialize message_class variable.

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['admin_code'])) {
    $admin_code = mysqli_real_escape_string($connect, $_POST['admin_code']);

    // Validate it's a 4-digit number
    if (!preg_match('/^\d{4}$/', $admin_code)) {
        $message = "Code must be exactly 4 digits.";
        $message_class = "error"; // Set message class for error
        $_SESSION['message'] = $message; // Store message in session
        $_SESSION['message_class'] = $message_class;
    } else {
        $query = "INSERT INTO admin_codes (code) VALUES ('$admin_code')";
        if (mysqli_query($connect, $query)) {
            $message = "Code $admin_code saved successfully!";
            $message_class = "success"; // Set message class for success

            // Store message and class in session before redirecting
            $_SESSION['message'] = $message;
            $_SESSION['message_class'] = $message_class;

            // Redirect to user_interface.php
            header("Location: user_interface.php");
            exit(); // Ensure no further code is executed
        } else {
            $message = "Error: " . mysqli_error($connect);
            $message_class = "error"; // Set message class for error
            $_SESSION['message'] = $message; // Store message in session
            $_SESSION['message_class'] = $message_class;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Code Setup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ecf0f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-section {
            background-color: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 350px;
        }
        h3 {
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #34495e;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #bdc3c7;
            font-size: 16px;
        }
        .submit-btn {
            width: 100%;
            background-color: #3498db;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #2980b9;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="form-section">
        <h3>Set Admin Code</h3>
        <?php 
        // Display the message from session if it's set
        if (isset($_SESSION['message'])) {
            echo "<p class='message {$_SESSION['message_class']}'>{$_SESSION['message']}</p>";
            unset($_SESSION['message']); // Clear the message after displaying it
            unset($_SESSION['message_class']); // Clear the message class
        }
        ?>
        <form method="post">
            <div class="form-group">
                <label for="admin_code">Admin Code (4-digit):</label>
                <input type="text" name="admin_code" maxlength="4" required>
            </div>
            <button type="submit" class="submit-btn">Save Code</button>
        </form>
    </div>
</body>
</html>