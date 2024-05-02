<?php include 'admin/includes/functions.php' ?>

<?php

echo password_hash('secret', PASSWORD_BCRYPT, array('cost' => 10));


?>