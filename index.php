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
                    $query = "SELECT * FROM posts WHERE post_status = 'published' ";
                    $select_all_posts = mysqli_query($connection, $query);

                    if(mysqli_num_rows($select_all_posts) > 0) {
                        while($post = mysqli_fetch_assoc($select_all_posts)) {
                            
                            $blog_post_id = $post['post_id'];
                            $blog_post_title = $post['post_title'];
                            $blog_post_author = $post['post_author'];
                            $blog_post_date = $post['post_date'];
                            $blog_post_image = $post['post_image'];
                            $blog_post_content = substr($post['post_content'], 0, 100);
                            $post_status = $post['post_status'];
                            $author_name = getAuthorByPost($blog_post_author);

                            echo "
                                <h2>
                                    <a href='post.php?p_id={$blog_post_id}'>
                                        $blog_post_title
                                    </a>
                                </h2>
                                <p class='lead'>by
                                    <a href='index.php'>
                                        $author_name
                                    </a>
                                </p>
                                <p>
                                    <span class='glyphicon glyphicon-time'></span> Posted on $blog_post_date
                                </p><a href='post.php?p_id={$blog_post_id}'>
                                <img class='img-responsive' src='images/$blog_post_image' alt=''>
                                </a>
                                <hr>
                                <p>
                                $blog_post_content...
                                </p>
                                <a class='btn btn-primary' href='post.php?p_id={$blog_post_id}'>Read More 
                                    <span class='glyphicon glyphicon-chevron-right'>
                                    </span>
                                </a>
                                <hr>
                                ";
                            }
                        } else {
                            echo "<h1>No posts!</h1>";
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