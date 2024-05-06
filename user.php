<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php
    if(isset($_GET['u_id'])) {
        $user = $_GET['u_id'];
        $query = "SELECT * FROM users WHERE user_id = {$user} ";
        $retrieved_user = mysqli_query($connection, $query);
        checkQuery($retrieved_user);
        while($row = mysqli_fetch_assoc($retrieved_user)) {
            $user_id = $row['user_id'];
            $user_name = $row['user_name'];
            $user_fn = $row['user_fn'];
            $user_ln = $row['user_ln'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
        }
        $comments = getCommentCountByUser($user_email);
        $posts = getPostCountByUser($user_id);
    }
?>

<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container thumbnail">
    <div class="col-md-3">
    <img class="pull-left" src="images/user/<?php echo $user_image ?>" alt="" height="200">
    </div>

        <div class="col-md-3 alert">
            <h1><?php echo $user_name; ?></h1>
        </div>
        <div class="alert">
            <p>
                Full name:
                <?php echo $user_fn; ?> 
                <?php echo $user_ln; ?>
            </p>
            <p>
                Email: <?php echo $user_email; ?>
            </p>

            <p>
                <a href="index.php?u_id=<?php echo $user_id; ?>&filter=by_author">
                    Posts: <?php echo $posts; ?>
                </a>
            </p>

            <p>
                Comments: <?php echo $comments; ?>
            </p>
        </div>
</div>