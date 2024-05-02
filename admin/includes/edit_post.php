<?php
    $post_to_edit = $_GET['p_id'];
    $query = "SELECT * FROM posts WHERE post_id = '{$post_to_edit}'";
    $post_edit_id = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($post_edit_id)) {
        $id = $row['post_id'];
        $author = $row['post_author'];
        $title = $row['post_title'];
        $cat = $row['post_category_id'];
        $status = $row['post_status'];
        $image = $row['post_image'];
        $tags = $row['post_tags'];
        $date = $row['post_date'];
        $content = $row['post_content'];
        $author_name = getAuthorByPost($author);
    }

    if(isset($_POST['update_post'])) {
        $post_title = escape($_POST['title']);
        $post_category_id = escape($_POST['post_category']);
        $post_status = escape($_POST['post_status']);
        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];
        $post_tags = escape($_POST['post_tags']);
        $post_content = escape($_POST['post_content']);

        move_uploaded_file($post_image_temp, "../images/$post_image");

        if(empty($post_image)) {
            $post_image = $image;
        }

        $query = "UPDATE posts SET post_title = '{$post_title}', post_category_id = {$post_category_id}, " .
                "post_status = '{$post_status}', post_image = '{$post_image}', post_tags = '{$post_tags}', post_content = '{$post_content}' " .
                "WHERE post_id = {$post_to_edit} ";

        $update_post = mysqli_query($connection, $query);

        checkQuery($update_post);
        header("Location: posts.php?notify=updated&p_id={$id}&p_title={$post_title}");
    }
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="post_author">Post Author: <?php echo $author_name; ?></label>
    </div>

    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php if(isset($title)) { echo $title; } ?>" type="text" class="form-control" name="title">
    </div>

    <div class="form-group col-xs-6">
        <label for="post_category">Post Category:</label>
        <select class="form-control" name="post_category" id="">
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

    <div class="form-group col-xs-6">
        <label for="post_status">Post Status</label>
        <select class="form-control" name="post_status" id="">
            <option value="<?php if(isset($status)) { echo $status; } ?>"><?php echo $status; ?></option>
            <option value="<?php 
                if($status === 'draft') {
                    echo $stt = "published";
                } else {
                    echo $stt = 'draft';
                } ?>"><?php echo $stt; ?></option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <div><img src='../images/<?php echo $image ?>' alt='image' style="height:100px;"></div>
        <input type="file" name="post_image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php if(isset($tags)) { echo $tags; } ?>" type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="summernote">Post Content</label>
        <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"><?php if(isset($content)) { echo $content; } ?></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>

</form>