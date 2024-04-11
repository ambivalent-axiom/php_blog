
<?php

    if(isset($_POST['add_user'])) {
        $user_name = $_POST['username'];
        $user_pass = $_POST['pass'];
        $user_fname = $_POST['fname'];
        $user_lname = $_POST['lname'];
        $user_email = $_POST['email'];

        // $user_image = $_FILES['user_image']['name'];
        // $user_image_temp = $_FILES['user_image']['tmp_name'];

        $user_role = $_POST['user_role'];

        // move_uploaded_file($post_image_temp, "../images/user/$post_image");

        $query = "INSERT INTO users (user_name, user_pass, user_fn, user_ln, user_email, user_role) " . 
                "VALUES ('{$user_name}', '{$user_pass}', '{$user_fname}', '{$user_lname}', '{$user_email}', '{$user_role}') ";

        $update_post = mysqli_query($connection, $query);

        checkQuery($update_post);

    }

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="pass">Password</label>
        <input type="text" class="form-control" name="pass">
    </div>

    <div class="form-group">
        <label for="fname">First Name</label>
        <input type="text" class="form-control" name="fname">
    </div>

    <div class="form-group">
        <label for="lname">Last Name</label>
        <input type="text" class="form-control" name="lname">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email">
    </div>

    <!--<div class="form-group">
        <label for="user_image">Image</label>
        <input type="file" name="user_image">
    </div>-->

    <div class="form-group">
        <label for="user_role">Role</label>
        <select name="user_role" id="">
            <option value="admin">Admin</option>
            <option value="blogger">Blogger</option>
        </select>
    </div>

    <div class="form-group">
        <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
    </div>

</form>