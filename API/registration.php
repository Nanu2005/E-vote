<?php
include("guri.php");

$name = $_POST['name'];
$mobile = $_POST['mobile'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$address = $_POST['address'];
$image = $_FILES['photo']['name'];
$tmp_name = $_FILES['photo']['tmp_name'];
$role = $_POST['role'];
$gender = $_POST['gender'];

if ($password == $cpassword) {
    $upload_path = "../uploads images/" . basename($image);
    move_uploaded_file($tmp_name, $upload_path);

    $insert = mysqli_query($connect, "INSERT INTO user (name, mobile, address, photo, role, status, votes, password) 
                                      VALUES ('$name', '$mobile', '$address', '$image', '$role', 0, 0, '$password')");

    if ($insert) {
        echo "<script>
                alert('Registration is Successful');
                window.location.href = '../goura/loginnn.html';
              </script>";
    } else {
        echo "<script>
                alert('Some error Occurred!');
                window.location.href = '../goura/regii.html';
              </script>";
    }
} else {
    echo "<script>
            alert('Password and confirm password do not match');
            window.location.href = '../goura/regii.html';
          </script>";
}
?>
