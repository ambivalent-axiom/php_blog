<?php
    $user_edit_id = getUserById($_GET['u_id']);
    while($row = mysqli_fetch_assoc($user_edit_id)) {
        $user_id = $row['user_id'];
        $name = $row['user_name'];
        $pass = $row['user_pass'];
        $firstnm = $row['user_fn'];
        $lastnm = $row['user_ln'];
        $email = $row['user_email'];
        $image = $row['user_image'];
        $role = $row['user_role'];
    }

    if(isset($_POST['update_user'])) {
        $user_name = escape($_POST['username']);

        if(empty($_POST['pass'])) {
            $user_pass = $pass;
        } else {
            $user_pass = encryptPass($_POST['pass']);
        }
        
        $user_fname = escape($_POST['fname']);
        $user_lname = escape($_POST['lname']);
        $user_email = escape($_POST['email']);
        
        $user_image = $_FILES['user_image']['name'];
        $user_image_temp = $_FILES['user_image']['tmp_name'];

        if(empty($user_image)) {
            $user_image = $image;
        }

        if(isset($_POST['user_role'])) {
            $user_role = escape($_POST['user_role']);
        } else {
            $user_role = $role;
        }

        move_uploaded_file($user_image_temp, "../images/user/$user_image");
        
        $query = "UPDATE users SET user_name = '{$user_name}', user_pass = '{$user_pass}', " .
                "user_fn = '{$user_fname}', user_ln = '{$user_lname}', user_email = '{$user_email}', user_image = '{$user_image}', user_role = '{$user_role}' " .
                "WHERE user_id = {$user_id} ";

        $update_post = mysqli_query($connection, $query);

        checkQuery($update_post);
        header("Location: users.php");
    }
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="username">Username</label>
        <input value="<?php if(isset($name)) { echo $name; } ?>" type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="pass">Password</label>
        <input autocomplete="off" type="password" class="form-control" name="pass">
    </div>

    <div class="form-group">
        <label for="fname">First Name</label>
        <input value="<?php if(isset($firstnm)) { echo $firstnm; } ?>" type="text" class="form-control" name="fname">
    </div>

    <div class="form-group">
        <label for="lname">Last Name</label>
        <input value="<?php if(isset($lastnm)) { echo $lastnm; } ?>" type="text" class="form-control" name="lname">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input value="<?php if(isset($email)) { echo $email; } ?>" type="email" class="form-control" name="email">
    </div>

    <div class="form-group">
        <img class="input-lg pull-left" src="../images/user/<?php echo $image ?>" alt="image">
        <div class="figure">
            <label for="user_image">Image</label>
            <input type="file" name="user_image">
        </div>
    </div>

    <?php
        if($_SESSION['role'] === 'admin') {
            ?>
                <div class="form-group">
                    <label for="user_role">Role</label>
                    <select name="user_role" id="">
                        <option value="<?php echo $role ?>"><?php echo ucfirst($role) ?></option>
                        <?php
                            if($role == 'admin') {
                                echo "<option value='blogger'>Blogger</option>";
                            } else {
                                echo "<option value='admin'>Admin</option>";
                            }
                        ?>
                    </select>
                </div>
            <?php
        } 
    ?>

    <div class="form-group">
        <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
    </div>

</form>