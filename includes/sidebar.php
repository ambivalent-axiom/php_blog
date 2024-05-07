<div class="col-md-4">

<!-- Blog Search Well -->
<div class="well">
    <h4>Blog Search</h4>
    <form action="search.php" method="post">

    <div class="input-group">
        <input name="search" type="text" class="form-control">
        <span class="input-group-btn">
            <button name="submit" class="btn btn-default" type="submit">
                <span class="glyphicon glyphicon-search"></span>
        </button>
        </span>
    </div>
    </form><!-- search form-->

    <!-- /.input-group -->
</div>

<!-- Login Well -->
<div class="well">
    <form action="includes/login.php" method="post">
        <h4>Login: 
            <?php 
                if(isset($_GET['login'])) {
                    echo $_GET['login'];
                } else if (isset($_SESSION['id'])) {
                    echo $_SESSION['first_nm'] . " " . $_SESSION['last_nm'];
                } else {
                    echo "";
                }
            ?>
        </h4>
        <div class="form-group">
            <div class="form-group">
                <input name="username" type="text" class="form-control" placeholder="Username">
            </div>
            <div class="input-group">
                <input name="pass" type="password" class="form-control" placeholder="Password">
                <span class="input-group-btn">
                    <button name="login" class="btn btn-primary" type="submit">
                        Login
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>

<!-- Blog Categories Well -->
<div class="well">
    <h4>Blog Categories</h4>
    <div class="row">

    <?php
    $query = "SELECT * FROM categories ";
    $select_categories_sidebar = mysqli_query($connection, $query);

    ?>
        <div class="col-lg-12">
            <ul class="list-unstyled">
                <?php
                    while($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];
                        echo "<li><a href='index.php?cat_id={$cat_id}&filter=categorized'>{$cat_title}</a></li>";
                    }
                ?>
            </ul>
        </div>
    </div>
    <!-- /.row -->
</div>

<!-- Side Widget Well -->
<?php include "widget.php" ?>

</div>