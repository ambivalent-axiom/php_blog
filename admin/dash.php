<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                            $query = "SELECT * FROM posts ";
                            $select_all_posts = mysqli_query($connection, $query);
                            $post_counts = mysqli_num_rows($select_all_posts);
                        ?>
                        <div class='huge'>
                            <?php echo $post_counts ?>
                        </div>
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                            $query = "SELECT * FROM comments ";
                            $select_all_comments = mysqli_query($connection, $query);
                            $comment_counts = mysqli_num_rows($select_all_comments);
                        ?>
                        <div class='huge'><?php echo $comment_counts ?></div>
                        <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                            $query = "SELECT * FROM users ";
                            $select_all_users = mysqli_query($connection, $query);
                            $user_counts = mysqli_num_rows($select_all_users);
                        ?>
                        <div class='huge'><?php echo $user_counts ?></div>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                            $query = "SELECT * FROM categories ";
                            $select_all_categories = mysqli_query($connection, $query);
                            $category_counts = mysqli_num_rows($select_all_categories);
                        ?>
                        <div class='huge'><?php echo $category_counts ?></div>
                        <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- /.row -->

<div class="row">
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
            ['', 'Count'],

            <?php
                $query_get_pending_comments = "SELECT * FROM comments WHERE com_status = 'Pending' ";
                $query_get_draft_posts = "SELECT * FROM posts WHERE post_status = 'draft' ";
                $get_pending_comments = mysqli_query($connection, $query_get_pending_comments);
                $get_draft_posts = mysqli_query($connection, $query_get_draft_posts);
                $penging_comment_count = mysqli_num_rows($get_pending_comments);
                $draft_post_count = mysqli_num_rows($get_draft_posts);
                $users_online = mysqli_num_rows(countUsrsOn());

                $element_text = ['Draft Posts', 'Pending Comments', 'Users Online'];
                $element_count = [$draft_post_count, $penging_comment_count, $users_online];
                for($i = 0; $i < 3; $i++) {
                    echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                }
            ?>

            ]);

            var options = {
            colors: ['gray'],
            chart: {
                title: '',
                subtitle: '',
            }
            };
            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
</div>