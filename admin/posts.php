<?php include "includes/admin_header.php" ?>
<body>
    <div id="wrapper">
        <?php include "includes/admin_navigation.php" ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">

                        <h1 class="page-header">
                            Posts
                            <small>John Smith</small>
                        </h1>
                        <?php
                            if(isset($_GET["source"])) {
                                $source = $_GET['source'];
                            } else {
                                $source = "";
                            }

                            if(isset($_GET['p_id'])) {
                                $post_id = $_GET['p_id'];
                            }
                        
                            switch($source) {

                                case 'add_post';
                                include "includes/add_post.php";
                                break;

                                case 'edit';
                                include "includes/edit_post.php";
                                break;

                                case 'pub';
                                    $query = "UPDATE posts SET post_status = 'published' WHERE 	post_id = {$post_id} ";
                                    $publish = mysqli_query($connection, $query);
                                    checkQuery($publish);
                                    header("Location: posts.php");
                                break;

                                case 'draft';
                                    $query = "UPDATE posts SET post_status = 'draft' WHERE 	post_id = {$post_id} ";
                                    $publish = mysqli_query($connection, $query);
                                    checkQuery($publish);
                                    header("Location: posts.php");
                                break;

                                default:
                                include "includes/view_all_posts.php";
                                break;
                            }
                    
                        ?>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php" ?>