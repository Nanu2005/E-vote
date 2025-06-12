<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
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
        <h2>Admin Login</h2>
        <form action="admin_login.php" method="POST">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <input type="submit" name="login" value="Login">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
            // Connect to the database
            $conn = new mysqli("localhost", "root", "", "voting_db");

            // Check connection
            if ($conn->connect_error) {
                echo '<p class="message error">Connection failed: ' . $conn->connect_error . '</p>';
            } else {
                // Get the data from the login form
                $username = $_POST['username'];
                $password = $_POST['password'];

                // Prepare the SQL query to get the stored hashed password
                $sql = "SELECT password FROM admin_table WHERE username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($stored_hash);
                $stmt->fetch();

                // Check if the username exists
                if ($stmt->num_rows > 0) {
                    // Verify the hashed password
                    if (password_verify($password, $stored_hash)) {
                        // Redirect to the admin code page after successful login
                        header("Location: admin_code.php");
                        exit(); // Ensure no further code is executed after redirect
                    } else {
                        echo '<p class="message error">Incorrect password.</p>';
                    }
                } else {
                    echo '<p class="message error">Username not found.</p>';
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
