
<?php

    if(isset($_POST['create_post'])) {
        $post_title = mysqli_real_escape_string($connection, $_POST['title']);
        $post_author = $_SESSION['id'];
        $post_category_id = $_POST['post_category_id'];

        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];

        $post_tags = mysqli_real_escape_string($connection, $_POST['post_tags']);
        $post_content = mysqli_real_escape_string($connection, $_POST['post_content']);
        $post_date = date('Y-m-d');

        move_uploaded_file($post_image_temp, "../images/$post_image");

        $query = "INSERT INTO posts (post_id, post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) " . 
                "VALUES (NULL, '{$post_category_id}', '{$post_title}', '{$post_author}', '{$post_date}', '{$post_image}', '{$post_content}', '{$post_tags}', 'draft')";

        $update_post = mysqli_query($connection, $query);
        checkQuery($update_post);
        $post_id = mysqli_insert_id($connection);

        header("Location: posts.php?notify=created&p_title={$post_title}&p_id={$post_id}");
    }

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="post_category_id">Post Category:</label>
        <select name="post_category_id" id="">
            <?php
                $query = "SELECT * FROM categories ";
                $select_categories_all = mysqli_query($connection, $query);
                checkQuery($select_categories_all);
                while($row = mysqli_fetch_assoc($select_categories_all)) {
                    $cat_title = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                    echo $cat_id;
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
  
        <label for="summernote">Post Content</label>
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"></textarea>

    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>

</form>