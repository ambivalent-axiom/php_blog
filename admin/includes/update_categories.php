<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Category</label>

        <?php
            if(isset($_GET['edit'])) {

                $cat_id = $_GET['edit'];
                $select_categories_id = "SELECT * FROM categories WHERE cat_id = $cat_id ";
                $select_categories_all = mysqli_query($connection, $select_categories_id);
                
                while($row = mysqli_fetch_assoc($select_categories_all)) {
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                    ?>
                        <input value="<?php
                                if(isset($cat_title)){
                                    echo $cat_title;
                                }
                            ?>" type="text" class="form-control" name="cat_title">
                <?php 
            } 
        }?>
        <?php //update query
            if(isset($_POST['update_category'])) {
                $the_cat_title = escape($_POST['cat_title']);
                $query = "UPDATE categories SET cat_title = '{$the_cat_title}' WHERE cat_id = {$cat_id} ";
                $update = mysqli_query($connection, $query);
                    if(!$update) {
                        die("Query failed!" . mysqli_error($connection));
                    }
                //header("Location: categories.php");
            }
        ?>



    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
    </div>
</form>