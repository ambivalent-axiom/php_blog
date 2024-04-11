
<table class="table table-bordered table-hover">
    <thead>
        <tr>
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
            ?>  <tr>
                    <td><?php echo $id ?></td>
                    <td><?php echo $author ?></td>
                    <td><?php echo $title ?></td>
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
                    <td><a href="?delete=<?php echo $id ?>">Delete</a> | 
                        <a href="?source=edit&p_id=<?php echo $id ?>">Edit</a> | 
                        <a href="?source=pub&p_id=<?php echo $id ?>">Publish</a> | 
                        <a href="?source=draft&p_id=<?php echo $id ?>">Draft</a>
                    </td>
                </tr>
            <?php
        }
        ?>
</tbody>
</table>

<?php
    deletePost();
?>




