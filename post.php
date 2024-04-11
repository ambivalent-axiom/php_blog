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
                    }

                    $query = "SELECT * FROM posts WHERE post_id = {$post_id} ";
                    $select_all_posts = mysqli_query($connection, $query);

                    while($post = mysqli_fetch_assoc($select_all_posts)) {
                        $blog_post_title = $post['post_title'];
                        $blog_post_author = $post['post_author'];
                        $blog_post_date = $post['post_date'];
                        $blog_post_image = $post['post_image'];
                        $blog_post_content = $post['post_content'];
                        echo "
                            <h2>
                                <a href='#'>
                                    $blog_post_title
                                </a>
                            </h2>
                            <p class='lead'>by
                                <a href='index.php'>
                                    $blog_post_author
                                </a>
                            </p>
                            <p>
                                <span class='glyphicon glyphicon-time'></span> Posted on $blog_post_date
                            </p>
                            <img class='img-responsive' src='images/$blog_post_image' alt=''>
                            <hr>
                            <p>
                            $blog_post_content
                            </p>
                            <a class='btn btn-primary' href='#'>Read More 
                                <span class='glyphicon glyphicon-chevron-right'>
                                </span>
                            </a>
                            <hr>
                            ";
                    }
                    ?>

                <!-- Blog Comments -->

                <!-- Comments Form -->

                    <?php
                        if(isset($_POST['comment'])) {
                            $com_auth = $_POST['name'];
                            $com_email = $_POST['email'];
                            $comment = $_POST['com_content'];

                            $query = "INSERT INTO comments (com_post_id, com_author, com_email, com_content, com_date) " .
                                    "VALUES ({$post_id}, '{$com_auth}', '{$com_email}', '{$comment}', now()) ";

                            $save_comm = mysqli_query($connection, $query);
                            checkQuery($save_comm);

                            $increment_com = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $post_id";
                            $Update_com_count = mysqli_query($connection, $increment_com);
                            checkQuery($increment_com);
                        }
                    ?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="col-xs-6">
                            <label for="name">Name: </label>
                            <input type="text" class="form-control" name="name">
                        </div>

                        <div class="col-xs-6">
                            <label for="email">e-mail: </label>
                            <input type="email" class="form-control" name="email">
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
                    $query = "SELECT * FROM comments WHERE com_status = 'Approved' AND com_post_id = $post_id ORDER BY com_id DESC ";
                    $get_comments = mysqli_query($connection, $query);
                    checkQuery($get_comments);

                    while($comment = mysqli_fetch_assoc($get_comments)) {
                        $author = $comment['com_author'];
                        $email = $comment['com_email'];
                        $date = $comment['com_date'];
                        $content = $comment['com_content'];

                        ?>
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $author ?>
                                    <small><?php echo $date ?></small>
                                    <small><?php echo $email ?></small>
                                </h4>
                                    <?php echo $content ?>
                                </div>
                            </div>
                        <?php
                    }
                ?>

                    <!-- Pager -->
                    <ul class="pager">
                        <li class="previous">
                            <a href="#">&larr; Older</a>
                        </li>
                        <li class="next">
                            <a href="#">Newer &rarr;</a>
                        </li>
                    </ul>

                    </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>
<!-- Footer -->
 <?php include "includes/footer.php" ?>