<?php
session_start();
$email = isset($_SESSION['registered_email']) ? $_SESSION['registered_email'] : '';
?>

<script>
    localStorage.setItem("pre_filled_email", "<?php echo $email; ?>");
    window.location.href = "loginnn.html";
</script>
