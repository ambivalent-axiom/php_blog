<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php
    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $username = escape($username);
        $password = escape($password);
        $email = escape($email);

        if(empty($username) || empty($password) || empty($email)) {
            echo "<script>alert('Fields cannot be empty!')</script>";
        } else {
            if(checkIfExists('user_name', $username) === true) {
                echo "<script>alert('User {$username} already exists.')</script>";
            } else if(checkIfExists('user_email', $email)) {
                echo "<script>alert('Email: {$email} already in use.')</script>";
            } else {
                $password = encryptPass($password);
                $query = "INSERT INTO users (user_name, user_pass, user_email, user_role) VALUES ('{$username}', '{$password}', '{$email}', 'blogger' ) ";
                $add_user = mysqli_query($connection, $query);
                checkQuery($add_user);
                echo "<script>alert('User {$username} registration success!')</script>";
           
            } 
        }
        
    }
?>



    <!-- Navigation -->
    <?php  include "includes/navigation.php"; ?>
    
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                        </div>
                         <div class="form-group">
                            <label for="body" class="sr-only">Text field</label>
                            <textarea class="form-control" name="" id=""></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
