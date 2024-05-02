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
                            Comments
                            <small><?php getUserLnFn(); ?></small>
                        </h1>
                        <?php
                            if(isset($_GET["source"])) {
                                $source = $_GET['source'];

                            } else {
                                $source = "";
                            }
                            
                            switch($source) {

                                case 'appr';
                                    $com_id = $_GET['com_id'];
                                    $query = "UPDATE comments SET com_status = 'approved' WHERE com_id = {$com_id} ";
                                    $exec_query = mysqli_query($connection, $query);
                                    checkQuery($exec_query);
                                    header("Location: comments.php?p_id=" . $_GET['p_id']);
                                break;

                                case 'dis';
                                    $com_id = $_GET['com_id'];
                                    $query = "UPDATE comments SET com_status = 'disapproved' WHERE com_id = {$com_id} ";
                                    $exec_query = mysqli_query($connection, $query);
                                    checkQuery($exec_query);
                                    header("Location: comments.php?p_id=" . $_GET['p_id']);
                                break;

                                case 'del';
                                    $com_id = $_GET['com_id'];
                                    $query = "DELETE FROM comments WHERE com_id = {$com_id} ";
                                    $exec_query = mysqli_query($connection, $query);
                                    checkQuery($exec_query);
                                    header("Location: comments.php?p_id=" . $_GET['p_id']);
                                break;

                                default:
                                include "includes/view_all_comments.php";
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