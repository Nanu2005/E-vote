<?php
session_start();
include("gurii.php");  // Database connection

$name = $_POST['name'];
$email = $_POST['email']; // ✅ Add this
$mobile = $_POST['mobile'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$address = $_POST['address'];
$role = $_POST['role'];
$gender = $_POST['gender'];

$image = $_FILES['photo']['name'];
$tmp_name = $_FILES['photo']['tmp_name'];
$upload_dir = "uploads_images/";
$upload_path = $upload_dir . basename($image);

// Create folder if not exists
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($password === $cpassword) {
    // Upload image
    if (move_uploaded_file($tmp_name, $upload_path)) {

        // Check if mobile already exists
        $check_mobile = mysqli_query($connect, "SELECT * FROM reg_user WHERE mobile='$mobile'");
        if (mysqli_num_rows($check_mobile) > 0) {
            echo "<script>
                    alert('Mobile number already registered! Try a different one.');
                    window.location.href = 'regii.html';
                  </script>";
            exit();
        }

        // Insert user into DB
        $insert = mysqli_query($connect, "INSERT INTO reg_user (name, mobile, address, photo, role, status, votes, password) 
                                          VALUES ('$name', '$mobile', '$address', '$image', '$role', 0, 0, '$password')");

        if ($insert) {
            $_SESSION['voter_name'] = $name;
            $_SESSION['registered_email'] = $email; // ✅ Store email in session

            header("Location: login_redirect.php"); // ✅ redirect to PHP page that loads loginnn.html with email filled
            exit();
        } else {
            echo "<script>
                    alert('Database Error!');
                    window.location.href = 'regii.html';
                  </script>";
        }

    } else {
        echo "<script>
                alert('Image upload failed!');
                window.location.href = 'regii.html';
              </script>";
    }
} else {
    echo "<script>
            alert('Passwords do not match!');
            window.location.href = 'regii.html';
          </script>";
}
?>
