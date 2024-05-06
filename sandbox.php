<?php 
    include 'admin/includes/functions.php';
    include 'includes/db.php';
?>

<?php

$userInput = "<script> alert('hello'); </script>";
echo $userInput;
//echo htmlspecialchars($userInput, ENT_QUOTES, 'UTF-8');
?>