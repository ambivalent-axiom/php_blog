<?php session_start(); ?>

<?php
    $_SESSION['username'] = null;
    $_SESSION['id'] = null;
    $_SESSION['first_nm'] = null;
    $_SESSION['last_nm'] = null;
    $_SESSION['email'] = null;
    $_SESSION['image'] = null;
    $_SESSION['role'] = null;

    header("Location: ../index.php");
?>