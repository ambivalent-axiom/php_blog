
<?php
    $db['host'] = 'localhost';
    $db['user'] = 'root';
    $db['pass'] = '';
    $db['name'] = 'cms';

//check if db connection constants are defined, if not, define.
    if(!defined('HOST')) {
        foreach($db as $key => $value) {
            define(strtoupper($key), $value);
        }
    }

    $connection = mysqli_connect(HOST, USER, PASS, NAME);

    if(!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>
