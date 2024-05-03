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
                        if(isset($_POST['submit'])) {
                            $search = escape($_POST['search']);
                            $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' ";
                            $search_query = mysqli_query($connection, $query);
                            if(!$search_query) {
                                die("Query Failed" . mysqli_error($connection));
                            }

                            $count = mysqli_num_rows($search_query);
                            if($count == 0) {
                                echo "<h1>No result!</h1>";
                            } else {
                                while($post = mysqli_fetch_assoc($search_query)) {
                                    $blog_post_id = $post['post_id'];
                                    $blog_post_title = $post['post_title'];
                                    $blog_post_author = $post['post_author'];
                                    $blog_post_date = $post['post_date'];
                                    $blog_post_image = $post['post_image'];
                                    $blog_post_content = $post['post_content'];
                                    $author_name = getAuthorByPost($blog_post_author);
                                    ?>
                                        <h2>
                                            <a href='post.php?p_id=<?php echo $blog_post_id; ?>'>
                                                <?php echo $blog_post_title ?>
                                            </a>
                                        </h2>
                                        <p class='lead'>by
                                            <a href='user.php?u_id=<?php echo $blog_post_author ?>'>
                                                <?php echo $author_name ?>
                                            </a>
                                        </p>
                                        <p>
                                            <span class='glyphicon glyphicon-time'></span> Posted on <?php echo $blog_post_date; ?>
                                        </p>
                                        <a href="post.php?p_id=<?php echo $blog_post_id ?>">
                                            <img class='img-responsive' src='images/<?php echo $blog_post_image ?>' alt=''>
                                        </a>
                                        <hr>
                                        <p>
                                        <?php echo $blog_post_content ?>
                                        </p>
                                        <a class='btn btn-primary' href='post.php?p_id=<?php echo $blog_post_id ?>'>Read More 
                                            <span class='glyphicon glyphicon-chevron-right'>
                                            </span>
                                        </a>
                                        <hr>
                                    <?php
                                }
                            }
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