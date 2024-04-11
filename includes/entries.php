<?php include "includes/db.php" ?>

<div class="col-md-8">

<!-- First Blog Post -->


<?php
$query = "SELECT * FROM posts ";
$select_all_posts = mysqli_query($connection, $query);

while($post = mysqli_fetch_assoc($select_all_posts)) {
    $blog_post_title = $post['post_title'];
    $blog_post_author = $post['post_author'];
    $blog_post_date = $post['post_date'];
    $blog_post_image = $post['post_image'];
    $blog_post_content = $post['post_content'];
    echo "
        <h2>
            <a href='#'>
                $blog_post_title
            </a>
        </h2>
        <p class='lead'>by
            <a href='index.php'>
                $blog_post_author
            </a>
        </p>
        <p>
            <span class='glyphicon glyphicon-time'></span> Posted on $blog_post_date
        </p>
        <img class='img-responsive' src='images/$blog_post_image' alt=''>
        <hr>
        <p>
        $blog_post_content
        </p>
        <a class='btn btn-primary' href='#'>Read More 
            <span class='glyphicon glyphicon-chevron-right'>
            </span>
        </a>
        <hr>
        ";
}

?>

<!-- Pager -->
<ul class="pager">
    <li class="previous">
        <a href="#">&larr; Older</a>
    </li>
    <li class="next">
        <a href="#">Newer &rarr;</a>
    </li>
</ul>

</div>