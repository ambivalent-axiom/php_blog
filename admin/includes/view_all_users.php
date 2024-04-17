<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>e-mail</th>
            <th>Image</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM users ";
        $all_users = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($all_users)) {
            $id = $row['user_id'];
            $name = $row['user_name'];
            $firstnm = $row['user_fn'];
            $lastnm = $row['user_ln'];
            $email = $row['user_email'];
            $image = $row['user_image'];
            $role = $row['user_role'];
            ?>  <tr>
                    <td><?php echo $id ?></td>
                    <td><?php echo $name ?></td>
                    <td><?php echo $firstnm . " " . $lastnm ?></td>
                    <td><?php echo $email ?></td>
                    <td><?php echo $image ?></td>
                    <td><?php echo $role ?></td>
                    <td><a href="?source=edit&u_id=<?php echo $id ?>">Edit</a> | 
                        <a href="?source=del&u_id=<?php echo $id ?>">Delete</a>
                    </td>
                </tr>
            <?php
        }
        ?>
</tbody>
</table>