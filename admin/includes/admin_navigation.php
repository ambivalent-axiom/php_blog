        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CMS Admin</a>
            </div>
            <!-- Top Menu Items -->
            <?php
                if($_SESSION['role'] == 'admin') {
                    ?><ul class="nav navbar-left top-nav" style="padding-left: 100px">
                        <li>
                            <a href="users.php?source=online" style="background-color: transparent;">Users Online: <span class="usersonline"></span></a>
                        </li>
                    </ul><?php
                }
            ?>

            <ul class="nav navbar-right top-nav">
                <li><a href="../index.php">CMS</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php getUserLnFn(); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="users.php?source=edit&u_id=<?php echo $_SESSION['id']; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-clipboard"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="posts_dropdown" class="collapse">
                            <li>
                                <a href="posts.php">View All posts</a>
                            </li>
                            <li>
                                <a href="posts.php?source=add_post&notify=add">Add posts</a>
                            </li>
                        </ul>
                    </li>
                    
                    <?php
                        if($_SESSION['role'] === 'admin') {
                            echo "<li>
                                    <a href='categories.php'><i class='fa fa-fw fa-list'></i> Categories</a>
                                </li>
                                <li>
                                    <a href='javascript:;' data-toggle='collapse' data-target='#users'><i class='fa fa-fw fa-users'></i> Users <i class='fa fa-fw fa-caret-down'></i></a>
                                    <ul id='users' class='collapse'>
                                        <li>
                                            <a href='users.php'>View all Users</a>
                                        </li>
                                        <li>
                                            <a href='users.php?source=add_user'>Add User</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href='comments.php'><i class='fa fa-fw fa-comments'></i> Comments</a>
                                </li>";
                        }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>