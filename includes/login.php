<?php 
    include "db.php";
    include "../admin/includes/functions.php";
    session_start();
?>

<?php
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['pass'];
    $username = escape($username);
    $password = escape($password);

    $query = "SELECT * FROM users WHERE user_name = '{$username}' ";
    $exec_query = mysqli_query($connection, $query);

    if(!$exec_query) {
        die("Query Fail " . mysqli_error($connection));
    }
    while($row = mysqli_fetch_assoc($exec_query)) {
        $user_id = $row['user_id'];
        $user_nm = $row['user_name'];
        $user_fnm = $row['user_fn'];
        $user_lnm = $row['user_ln'];
        $user_pass = $row['user_pass'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }

    if(password_verify($password, $user_pass)) { //this checks if provided pass is the same as the pass in db taking in account encryption.
        $_SESSION['username'] = $user_nm;
        $_SESSION['id'] = $user_id;
        $_SESSION['first_nm'] = $user_fnm;
        $_SESSION['last_nm'] = $user_lnm;
        $_SESSION['email'] = $user_email;
        $_SESSION['image'] = $user_image;
        $_SESSION['role'] = $user_role;
        header("Location: ../index.php?login={$_SESSION['username']}");
    } else {
        header("Location: ../index.php?login=Wrong username or pass.");
    }
}
?>