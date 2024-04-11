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
                            Users
                            <small><?php getUserLnFn(); ?></small>
                        </h1>
                        <?php
                        
                            if(isset($_GET["source"])) {
                                $source = $_GET['source'];

                            } else {
                                $source = "";
                            }

                            if (isset($_GET['u_id'])) {
                                $user_id = $_GET['u_id'];
                            }
                        
                            switch($source) {

                                case 'edit';
                                    include "includes/edit_user.php";
                                break;

                                case 'del';
                                    $query = "DELETE FROM users WHERE user_id = {$user_id} ";
                                    $exec_query = mysqli_query($connection, $query);
                                    checkQuery($exec_query);
                                    header("Location: users.php");
                                break;

                                case 'add_user';
                                    include "includes/add_user.php";
                                break;

                                default:
                                    if($_SESSION['role'] === 'admin') {
                                        include "includes/view_all_users.php";
                                    } else {
                                        header("Location: index.php");
                                    }
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