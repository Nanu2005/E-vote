<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            margin-top: 15px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 3px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Admin Registration</h2>
        <form action="admin_register.php" method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>Admin Code:</label>
            <input type="text" name="admin_code" required>

            <input type="submit" name="register" value="Register">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
            // Connect to the database
            $conn = new mysqli("localhost", "root", "", "voting_db");

            // Check connection
            if ($conn->connect_error) {
                echo '<p class="message error">Connection failed: ' . $conn->connect_error . '</p>';
            } else {
                // Get the data from the form
                $username = $_POST['username'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Securely hash the password
                $admin_code = $_POST['admin_code'];

                // Insert the admin data into the table
                $sql = "INSERT INTO admin_table (username, password, admin_code) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $username, $password, $admin_code);

                if ($stmt->execute()) {
                    // Redirect to login page after successful registration
                    header("Location: admin_login.php");
                    exit();
                } else {
                    echo '<p class="message error">Error: ' . $conn->error . '</p>';
                }

                // Close the prepared statement and connection
                $stmt->close();
                $conn->close();
            }
        }
        ?>
    </div>
</body>
</html>
