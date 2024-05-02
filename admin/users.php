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
                                case 'edit':
                                    if(isset($_GET['u_id'])) {
                                        include "includes/edit_user.php";
                                    } else {
                                        header("Location: users.php");
                                    }
                                break;

                                case 'del':
                                    deleteUser($user_id);
                                    header("Location: users.php");
                                break;

                                case 'online':
                                    if($_SESSION['role'] === 'admin') {
                                        include "includes/view_all_users.php";
                                    } else {
                                        header("Location: index.php");
                                    }
                                break;

                                case 'add_user':
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