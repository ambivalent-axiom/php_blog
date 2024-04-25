<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>e-mail</th>
            <th>Image</th>
            <th>Role</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if(isset($_GET['source']) && $_GET['source'] == 'online') {
                getUsersOnline($time_out);
            } else {
                getUsers();
            };
        ?>
</tbody>
</table>