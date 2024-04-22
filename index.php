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
                    if(isset($_GET['page'])){
                        switch($_GET['page']){
                            case 'categorized';
                                if(isset($_GET['cat_id'])) {
                                    $cat_filer = $_GET['cat_id'];
                                }
                                $query = "SELECT * FROM posts WHERE post_status = 'published' AND post_category_id = {$cat_filer} ORDER BY post_id DESC";
                                $select_all_posts = mysqli_query($connection, $query);
                                getPosts($select_all_posts);
                                break;

                            case 'by_author';
                                $user = $_GET["u_id"];
                                $query = "SELECT * FROM posts WHERE post_author = '$user' ORDER BY post_id DESC";
                                $author_posts = mysqli_query($connection, $query);
                                checkQuery($author_posts);
                                getPosts($author_posts);
                                break;
                        }
                    } else {
                        $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC";
                        $select_all_posts = mysqli_query($connection, $query);
                        if(mysqli_num_rows($select_all_posts) > 0) {
                            getPosts($select_all_posts);
                        } else {
                            echo "<h1>No posts!</h1>";
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
<!-- Footer -->
 <?php include "includes/footer.php" ?>