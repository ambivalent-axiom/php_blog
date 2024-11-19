<?php
    include_once 'env.php';
    $access = mariaAccess();
    $connection = mysqli_connect($access['host'], $access['user'], $access['pass'], $access['name']);

    if(!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }