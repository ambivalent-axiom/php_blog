<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Post</th>
            <th>Author</th>
            <th>Email</th>
            <th>Content</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(isset($_GET['p_id']) && $_GET['p_id'] != "") {
            echo "Comments filtered by post ID: " . $_GET['p_id'];
            $query = "SELECT * FROM comments WHERE com_post_id = {$_GET['p_id']} ";
            $p_id = $_GET['p_id'];
        } else {
            $query = "SELECT * FROM comments ";
            $p_id = "";
        }
        $all_posts = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($all_posts)) {
            $id = $row['com_id'];
            $post = $row['com_post_id'];
            $author = $row['com_author'];
            $email = $row['com_email'];
            $content = substr($row['com_content'], 0, 30);
            $date = $row['com_date'];
            $status = $row['com_status'];
            ?>  <tr>
                    <td><?php echo $id ?></td>
                    <td><?php
                        $query = "SELECT post_title FROM posts WHERE post_id = {$post} ";
                        $post_name = mysqli_query($connection, $query);
                        checkQuery($post_name);
                        $row = mysqli_fetch_assoc($post_name);
                        echo "<a href='../post.php?p_id={$post}'>{$row['post_title']}</a>";
                    ?></td>
                    <td><?php echo $author ?></td>
                    <td><?php echo $email ?></td>
                    <td><?php echo $content . "..."?></td>
                    <td><?php echo $date ?></td>
                    <td><?php echo $status ?></td>
                    <td><a href="?source=appr&com_id=<?php echo $id ?>&p_id=<?php echo $p_id ?>">Approve</a> | 
                        <a href="?source=dis&com_id=<?php echo $id ?>&p_id=<?php echo $p_id ?>">Disapprove</a> | 
                        <a href="?source=del&com_id=<?php echo $id ?>&p_id=<?php echo $p_id ?>">Delete</a>
                    </td>
                </tr>
            <?php
        }
        ?>
</tbody>
</table>