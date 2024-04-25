<?php include "includes/db.php" ?>
<?php session_start(); ?> 
   
   <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand glyphicon glyphicon-book" href="index.php"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php
                    $query = "SELECT * FROM categories ";
                    $select_all_categories_query = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($select_all_categories_query)) {
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];
                        echo "<li><a href='index.php?cat_id={$cat_id}&filter=categorized'>{$cat_title}</a></li>";
                    }
                    ?>
                </ul>
                <?php
                    if(isset($_SESSION['role'])) {
                        echo "<ul class='nav navbar-nav navbar-right'>
                                <li><a href='admin'>{$_SESSION['username']}</a></li></ul>";
                    } else {
                        echo "<ul class='nav navbar-nav navbar-right'>
                                <li><a href='registration.php'>Register</a></li></ul>";
                    }
                ?>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>