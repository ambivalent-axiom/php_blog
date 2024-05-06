<?php include "includes/header.php" ?>
<body>
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
                    <?php include "includes/db.php" ?>
                    <div class="col-md-8">
                    <!-- First Blog Post -->
                    <?php
                        if(isset($_GET['p_id'])) {
                            $post_id = $_GET['p_id'];
                            postViewed($post_id);
                        }
                    
                        //get the post
                        $query = "SELECT * FROM posts WHERE post_id = {$post_id} ";
                        $select_all_posts = mysqli_query($connection, $query);
                        while($post = mysqli_fetch_assoc($select_all_posts)) {
                            $blog_post_title = $post['post_title'];
                            $blog_post_author = $post['post_author'];
                            $blog_post_date = $post['post_date'];
                            $blog_post_image = $post['post_image'];
                            $blog_post_content = $post['post_content'];
                            $blog_post_views = $post['post_views'];
                        }

                        //get the data on author
                        $author_name = getAuthorByPost($blog_post_author);
                    ?>

                    <!-- post the post -->
                    <h2><?php echo $blog_post_title; ?></h2>
                        <p class='lead'>by
                            <a href='index.php'>
                                <?php echo $author_name; ?>
                            </a>
                            <?php
                                if(isset($_SESSION['id'])) {
                                    if($_SESSION['role'] === 'admin') {
                                        echo "<a href='admin/posts.php?source=edit&p_id={$post_id}&notify=edit'>[Edit Post]</a>";
                                    } else if ($_SESSION['id'] === $blog_post_author) {
                                        echo "<a href='admin/posts.php?source=edit&p_id={$post_id}&notify=edit'>[Edit Your Post]</a>";
                                    }
                                }
                            ?>
                        </p>
                    <p>
                        <span class='glyphicon glyphicon-time'></span> 
                            Posted on <?php echo $blog_post_date; ?> 
                            | Views: <?php echo $blog_post_views; ?>
                            | Comments: <?php echo getCommentCount($post_id); ?>
                    </p>
                        <img class='img-responsive' src='images/<?php echo $blog_post_image; ?>' alt=''>
                    <hr>
                        <p>
                            <?php echo $blog_post_content; ?>
                        </p>
                    <hr>

                <!-- Blog Comments -->
                <!-- Comments Form -->

                    <?php
                        if(isset($_POST['comment'])) {
                            if(isset($_SESSION['id'])) {
                                $com_auth = escape($_SESSION['username']);
                                $com_email = escape($_SESSION['email']);
                            } else {
                                $com_auth = escape($_POST['name']);
                                $com_email = escape($_POST['email']);
                            }
                            $comment = escape($_POST['com_content']);

                            if(!empty($com_auth) && !empty($com_email) && !empty($comment)) {
                                addComment($post_id, $com_auth, $com_email, $comment);
                            } else {
                                echo "<script>alert('Fields cannot be empty!')</script>";
                            }
                        }
                    ?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="col-xs-6">
                            <label for="name">Name: </label>
                            <input <?php 
                                if(isset($_SESSION['id'])) {
                                    echo "value={$_SESSION['username']}";
                                }
                                ?> type="text" class="form-control" name="name">
                        </div>
                        <div class="col-xs-6">
                            <label for="email">e-mail: </label>
                            <input <?php 
                                if(isset($_SESSION['id'])) {
                                    echo "value={$_SESSION['email']}";
                                }
                                ?> type="email" class="form-control" name="email">
                        </div>
                        <div class="col-xs-12 margin-bottom-space">
                            <label for="com_content">Leave a comment: </label>
                            <textarea class="form-control" name="com_content" rows="5"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="comment">Submit</button>
                        </div>   
                    </form>
                    
                <hr>
                <!-- Posted Comments -->
                <!-- Comment -->
                <?php
                    getComments('approved', $post_id);
                ?>
                </div>
            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>
        </div>
        <!-- /.row -->
        <hr>
<!-- Footer -->
 <?php include "includes/footer.php" ?>