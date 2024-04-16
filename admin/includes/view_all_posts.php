

<?php
if(isset($_POST['checkBoxArray'])) {
    foreach($_POST['checkBoxArray'] as $post_id) {
        $bulk_option = $_POST['bulk_options'];
        switch($bulk_option) {
            case 'publish';
                publishPost($post_id);
            break;

            case 'draft';
                draftPost($post_id);
            break;

            case 'delete';
                deletePost($post_id);
            break;
        }
    }
    header("Location: posts.php?notify=bulk");
}
?>


<form action="" method="post">
    <table class="table table-bordered table-hover">
        <div id="bulkOptionsContainer" class="col-xs-4 margin-bottom-space">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="publish">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
            </select>
        </div>

        <div>
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post&notify=add">Add New</a>
        </div>

        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM posts ";
            $all_posts = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($all_posts)) {
                $id = $row['post_id'];
                $author = $row['post_author'];
                $title = $row['post_title'];
                $cat = $row['post_category_id'];
                $status = $row['post_status'];
                $image = $row['post_image'];
                $tags = $row['post_tags'];
                $comments = $row['post_comment_count'];
                $date = $row['post_date'];
                $author_name = getAuthorByPost($author);
                ?>  <tr>
                        <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="<?php echo $id; ?>"></td>
                        <td><?php echo $id ?></td>
                        <td><?php echo $author_name ?></td>
                        <td><a href="../post.php?p_id=<?php echo $id; ?>"><?php echo $title ?></a></td>
                        <td><?php 
                            $query = "SELECT cat_title FROM categories WHERE cat_id = {$cat} ";
                            $get_cat_name = mysqli_query($connection, $query);
                            checkQuery($get_cat_name);
                            $row = mysqli_fetch_assoc($get_cat_name);
                            echo $row['cat_title'];
                        ?></td>
                        <td><?php echo $status ?></td>
                        <td><img src='../images/<?php echo $image ?>' alt='image' style="width:100px;height:50px;"></td>
                        <td><?php echo $tags ?></td>
                        <td><?php echo $comments ?></td>
                        <td><?php echo $date ?></td>
                        <td><a href="?source=delete&p_id=<?php echo $id ?>">Delete</a> | 
                            <a href="?source=edit&p_id=<?php echo $id ?>&notify=edit">Edit</a> | 
                            <a href="?source=pub&p_id=<?php echo $id ?>">Publish</a> | 
                            <a href="?source=draft&p_id=<?php echo $id ?>">Draft</a>
                        </td>
                    </tr>
                <?php
            }
            ?>
    </tbody>
    </table>
</form>




