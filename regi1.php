<?php
// include("gurii.php");

// $name = $_POST['name'];
// $mobile = $_POST['mobile'];
// $cpassword = $_POST['cpassword'];
// $address = $_POST['address'];
// $image = $_FILES['photo']['name'];
// $tmp_name = $_FILES['photo']['tmp_name'];
// $role = $_POST['role'];
// $gender = $_POST['gender'];

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $email = mysqli_real_escape_string($connect, $_POST['email']);
//     $password = mysqli_real_escape_string($connect, $_POST['password']);

//     // Check user credentials
//     $query = "SELECT * FROM user WHERE email='$email'";
//     $result = mysqli_query($connect, $query);
//     // $query1 = "SELECT * FROM reg_user WHERE ";
//     // $result1 = mysqli_query($connect, $query);

//     if (mysqli_num_rows($result) == 1) {
//         $user = mysqli_fetch_assoc($result);
        
//         // Verify the hashed password
//         if (password_verify($password, $user['password'])) {
//             session_start();
//             $_SESSION['user_id'] = $user['id'];
//             $_SESSION['firstname'] = $user['firstname'];
//             if ($password == $cpassword) {
//                 $upload_path = "../uploads images/" . basename($image);
//                 move_uploaded_file($tmp_name, $upload_path);
            
//                 $insert = mysqli_query($connect, "INSERT INTO reg_user (name, mobile, address, photo, role, status, votes) 
//                                                   VALUES ('$name', '$mobile', '$address', '$image', '$role', 0, 0)");
            
//                 if ($insert) {
//                     echo "<script>
//                             alert('Registration is Successful');
//                             window.location.href = 'loginnn.html';  // Go one level up to 'goura' folder
//                           </script>";
//                 } else {
//                     echo "<script>
//                             alert('Some error Occurred!');
//                             window.location.href = 'regii.html';  // Go one level up to 'goura' folder
//                           </script>";
//                 }
//             } else {
//                 echo "<script>
//                         alert('Password and confirm password do not match');
//                         window.location.href = 'regii.html';  // Go one level up to 'goura' folder
//                       </script>";
//             }
//             echo "<script>alert('Login successful!'); window.location.href = 'register.html';</script>";
//         } else {
//             echo "<script>alert('Incorrect password. Try again!'); window.location.href = 'loginnn.html';</script>";
//         }
//     } else {
//         echo "<script>alert('No account found with this email. Register first!'); window.location.href = 'loginnn.html';</script>";
//     }
// }
// include("gurii.php");

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Collect user data from POST request
//     $name = mysqli_real_escape_string($connect, $_POST['name']);
//     $email = mysqli_real_escape_string($connect, $_POST['email']);
//     $mobile = mysqli_real_escape_string($connect, $_POST['mobile']);
//     $address = mysqli_real_escape_string($connect, $_POST['address']);
//     $password = mysqli_real_escape_string($connect, $_POST['password']);
//     $cpassword = mysqli_real_escape_string($connect, $_POST['cpassword']);
//     $role = mysqli_real_escape_string($connect, $_POST['role']);
//     $gender = mysqli_real_escape_string($connect, $_POST['gender']);
//     $image = $_FILES['photo']['name'];
//     $tmp_name = $_FILES['photo']['tmp_name'];

//     // Check if passwords match
//     if ($password !== $cpassword) {
//         echo "<script>
//                 alert('Password and confirm password do not match');
//                 window.location.href = 'regii.html';  // Redirect to registration page
//               </script>";
//         exit();
//     }

//     // Check if email already exists in the 'user' table
//     $check_email = mysqli_query($connect, "SELECT * FROM user WHERE email='$email'");
//     if (mysqli_num_rows($check_email) == 0) {
//         echo "<script>
//                 alert('No account found with this email. Please register first.');
//                 window.location.href = 'loginnn.html';  // Redirect to login page
//               </script>";
//         exit();
//     }

//     // Fetch the password and confirm password from the 'user' table
//     $user = mysqli_fetch_assoc($check_email);
//     $db_password = $user['password'];  // Password from the 'user' table
//     $db_cpassword = $user['cpassword'];  // Confirm password from the 'user' table

//     // Check if the entered password and confirm password match with the one from the 'user' table
//     if ($password !== $db_password) {
//         echo "<script>
//                 alert('Password mismatch with the registered account.');
//                 window.location.href = 'regii.html';  // Redirect to registration page
//               </script>";
//         exit();
//     }

//     // Move uploaded photo to the 'uploads' directory
//     $upload_path = "../uploads/images/" . basename($image);
//     if (move_uploaded_file($tmp_name, $upload_path)) {
//         // Insert the new registration details into the 'reg_user' table
//         $insert_query = "INSERT INTO reg_user (name, email, mobile, password, cpassword, address, photo, role, gender) 
//                          VALUES ('$name', '$email', '$mobile', '$password', '$cpassword', '$address', '$image', '$role', '$gender')";

//         if (mysqli_query($connect, $insert_query)) {
//             echo "<script>
//                     alert('Registration Successful');
//                     window.location.href = 'loginnn.html';  // Redirect to login page
//                   </script>";
//         } else {
//             echo "<script>
//                     alert('Error occurred while registering. Please try again.');
//                     window.location.href = 'regii.html';  // Redirect to registration page
//                   </script>";
//         }
//     } else {
//         echo "<script>
//                 alert('Failed to upload the image. Please try again.');
//                 window.location.href = 'regii.html';  // Redirect to registration page
//               </script>";
//     }
// }
?>
