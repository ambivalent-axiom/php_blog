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
                            
                            <small><?php getUserLnFn(); ?></small>
                              |  
                            <?php
                                if(isset($_GET['notify'])) {
                                    $notify_about = $_GET['notify'];
                                } else {
                                    $notify_about = "";
                                }
                                switch($notify_about) {
                                    case 'bulk':
                                    echo "<small>Bulk operation performed at: " . date('Y-m-d H:i:s', time()) . "</small>";
                                    break;

                                    case 'edit':
                                    echo "<small>Post edit</small>";
                                    break;

                                    case 'add':
                                    echo "<small>Add new post</small>";
                                    break;

                                    case 'updated':
                                    echo "<small class='bg-success'>Post " . 
                                        "<a href='../post.php?p_id={$_GET['p_id']}'>{$_GET['p_title']}</a>" . 
                                        " has been updated.</small>";
                                    break;

                                    case 'created':
                                    echo "<small class='bg-success'>Post " . 
                                        "<a href='../post.php?p_id={$_GET['p_id']}'>{$_GET['p_title']}</a>" . 
                                        " has been created.</small>";
                                    break;

                                    case 'deleted':
                                    echo "<small class='bg-success'>Post ID {$_GET['p_id']} has been removed from database.</small>";
                                    break;

                                    case 'published':
                                    echo "<small class='bg-success'>Post ID {$_GET['p_id']} has been moved to published.</small>";
                                    break;

                                    case 'drafted':
                                    echo "<small class='bg-success'>Post ID {$_GET['p_id']} has been moved to draft.</small>";
                                    break;

                                    case 'reset_views':
                                        echo "<small class='bg-success'>Post ID {$_GET['p_id']} views counter reset.</small>";
                                    break;

                                    default:
                                    echo "<small>All posts from database</small>";
                                    break;
                                }

                            ?>
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

                            if(isset($_GET['auth_name'])) {
                                $author_name = $_GET['auth_name'];
                            }
                        
                            switch($source) {

                                case 'delete':
                                    deletePost($post_id);
                                    header("Location: posts.php?notify=deleted&p_id={$post_id}");
                                break;
                                    
                                case 'add_post':
                                    include "includes/add_post.php";
                                break;

                                case 'edit':
                                    include "includes/edit_post.php";
                                break;

                                case 'pub':
                                    publishPost($post_id);
                                    header("Location: posts.php?notify=published&p_id=$post_id");
                                break;

                                case 'draft':
                                    draftPost($post_id);
                                    header("Location: posts.php?notify=drafted&p_id=$post_id");
                                break;

                                case 'reset_views':
                                    resetViews($post_id);
                                    header("Location: posts.php?notify=reset_views&p_id=$post_id");
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