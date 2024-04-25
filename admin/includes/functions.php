<?php
function insert_categories() {
    global $connection;

    if(isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if($cat_title =="" || empty($cat_title)) {
            echo "Empty field submitted! No changes made.";
        } else {
            $query = "INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES (NULL, '{$cat_title}') ";
            $create = mysqli_query($connection, $query);
            if(!$create) {
                die("Query Failed!" . mysqli_error($connection));
            }
        }
    
    } 
}
function findAllCategories() {
    global $connection;
    $query = "SELECT * FROM categories ";
    $select_categories_all = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_categories_all)) {
        $cat_title = $row['cat_title'];
        $cat_id = $row['cat_id'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }


}
function deleteCategory() {
    global $connection;
    if(isset($_GET['delete'])) {
        $cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$cat_id} ";
        $delete = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}
function deletePost($post_to_delete) {
    global $connection;
    $clear_com_quer = "DELETE FROM comments WHERE com_post_id = $post_to_delete ";
    $query = "DELETE FROM posts WHERE post_id = {$post_to_delete} ";
    $clear_comments = mysqli_query($connection, $clear_com_quer);
    checkQuery($clear_comments);
    $execure_query = mysqli_query($connection, $query);
    checkQuery($execure_query);
}
function checkQuery($query) {
    global $connection;
    if(!$query) {
        die("Query Failed: " . mysqli_error($connection));
    }
}
function getUserLnFn() {
    if(isset($_SESSION['id'])) {
        echo $_SESSION['first_nm'] . " " . $_SESSION['last_nm'];
    } else {
        echo "Unregistered";
    }
}
function getAuthorByPost($author, $column='user_name') {
    global $connection;
    $query = "SELECT * FROM users WHERE user_id = $author ";
    $select_author = mysqli_query($connection, $query);
    switch($column) {
        case 'image';
            while($author = mysqli_fetch_assoc($select_author)) {
                return($author['user_image']);
            }
        break;

        default:
            while($author = mysqli_fetch_assoc($select_author)) {
                return($author['user_name']);
            }
        break;
    }
}
function publishPost($post_id) {
    global $connection;
    $query = "UPDATE posts SET post_status = 'published' WHERE 	post_id = {$post_id} ";
    $publish = mysqli_query($connection, $query);
    checkQuery($publish); 
}
function draftPost($post_id) {
    global $connection;
    $query = "UPDATE posts SET post_status = 'draft' WHERE 	post_id = {$post_id} ";
    $draft = mysqli_query($connection, $query);
    checkQuery($draft);
}
function addComment($post_id, $com_auth, $com_email, $comment) {
    global $connection;
    $query = "INSERT INTO comments (com_post_id, com_author, com_email, com_content, com_date) " .
    "VALUES ({$post_id}, '{$com_auth}', '{$com_email}', '{$comment}', now()) ";
    $save_comm = mysqli_query($connection, $query);
    checkQuery($save_comm);
    $increment_com = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $post_id";
    $Update_com_count = mysqli_query($connection, $increment_com);
    checkQuery($Update_com_count);
}
function checkIfExists($column, $value, $operation='check') {
    global $connection;
    $query = "SELECT * FROM users WHERE {$column} = '{$value}' ";
    $exec_query = mysqli_query($connection, $query);
    checkQuery($exec_query);
    switch($operation) {
        case 'check';
            if(mysqli_num_rows($exec_query) == 0) {
                return false;
            } else {
                return true;
            };
        break;

        case 'get_id';
            if(mysqli_num_rows($exec_query) >= 1) {
                while($user = mysqli_fetch_assoc($exec_query)) {
                    $user_id = $user['user_id'];
                    return $user_id;
                }
            } else {
                return false;
            };
        break;

        default:
            if(mysqli_num_rows($exec_query) == 0) {
                return false;
            } else {
                return true;
            };
        break;
    }

}
function encryptPass($pass) {
    $salt = addSalt();
    $encrypted_pass = crypt($pass, $salt);
    return $encrypted_pass;
}
function getAllPosts($access) {
    global $connection;
    if($access === 'admin') {
        $query = "SELECT * FROM posts ";
        $all_posts = mysqli_query($connection, $query);
        return $all_posts;
    } else {
        $query = "SELECT * FROM posts WHERE post_author = {$access} ";
        $all_posts = mysqli_query($connection, $query);
        return $all_posts;
    }
}
function getCommentCountByUser($email) {
    global $connection;
    $query = "SELECT * FROM comments WHERE com_email = '{$email}' ";
    $get_comments = mysqli_query($connection, $query);
    checkQuery($get_comments);
    return mysqli_num_rows($get_comments);
}
function getPostCountByUser($user_id) {
    global $connection;
    $query = "SELECT * FROM posts WHERE post_author= '{$user_id}' ";
    $get_posts = mysqli_query($connection, $query);
    checkQuery($get_posts);
    return mysqli_num_rows($get_posts);
}
function addSalt() {
    $charString = "abcdefghijklmnopqrstuvqxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $salt = "";
    for($i=1; $i<=8; $i++) {
        $index = rand(0, strlen($charString) - 1);
        $salt = $salt . $charString[$index];
    }
    return "$1$" . $salt;
}
function getPosts($sql) {
    while($post = mysqli_fetch_assoc($sql)) {
        $blog_post_id = $post['post_id'];
        $blog_post_title = $post['post_title'];
        $blog_post_author = $post['post_author'];
        $blog_post_date = $post['post_date'];
        $blog_post_image = $post['post_image'];
        $blog_post_content = $post['post_content'];
        $author_name = getAuthorByPost($blog_post_author);
        ?>
        <h2>
            <a href='post.php?p_id=<?php echo $blog_post_id; ?>'>
                <?php echo $blog_post_title ?> <?php echo $blog_post_id ?>
            </a>
        </h2>
        <p class='lead'>by
            <a href='user.php?u_id=<?php echo $blog_post_author ?>'>
                <?php echo $author_name ?>
            </a>
        </p>
        <p>
            <span class='glyphicon glyphicon-time'></span> Posted on <?php echo $blog_post_date ?>
        </p>
        <a href='post.php?p_id=<?php echo $blog_post_id ?>'>
            <img class='img-responsive' src='images/<?php echo $blog_post_image ?>' alt=''>
        </a>
        <hr>
        <p>
            <?php
            $clean_post_cont = strip_tags($blog_post_content);
            echo substr($clean_post_cont, 0, 100);
            ?>...
        </p>
        <a class='btn btn-primary' href='post.php?p_id=<?php echo $blog_post_id ?>'>Read More
            <span class='glyphicon glyphicon-chevron-right'></span>
        </a>
        <hr>
        <?php
    }
}
function clonePost($post_id) {
    global $connection;
    $query = "SELECT * FROM posts WHERE post_id = $post_id ";
    $select_post_query = mysqli_query($connection, $query);
    checkQuery($select_post_query);
    while($post = mysqli_fetch_assoc($select_post_query)) {
        $post_title = $post['post_title'];
        $post_author = $post['post_author'];
        $post_date = date('d-m-y');
        $post_image = $post['post_image'];
        $post_content = $post['post_content'];
        $post_category_id = $post['post_category_id'];
        $post_tags = $post['post_tags'];
    }
    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_status, post_tags) VALUES({$post_category_id}, '{$post_title}', {$post_author}, '{$post_date}', '{$post_image}', '{$post_content}', 'draft', '{$post_tags}') ";
    $clone_post = mysqli_query($connection, $query);
    checkQuery($clone_post);
}
function postViewed($post_id) {
    global $connection;
    $query = "UPDATE posts SET post_views = post_views + 1 WHERE post_id = $post_id ";
    $update_views = mysqli_query($connection, $query);
    checkQuery($update_views);
}
function resetViews($post_id) {
    global $connection;
    $query = "UPDATE posts SET post_views = 0 WHERE post_id = $post_id ";
    $update_views = mysqli_query($connection, $query);
    checkQuery($update_views);
}
//This lists posts on index page
function getPostCount($column="", $value="") {
    global $connection;
    if (empty($column)) {
        $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id";
    } else {
        $query = "SELECT * FROM posts WHERE post_status = 'published' AND {$column} = {$value} ORDER BY post_id";
    }
    $select_all_posts = mysqli_query($connection, $query);
    $post_count = mysqli_num_rows($select_all_posts);
    return $post_count;
}
function showPostsPaginated($column="", $value="", $offset) {
    $per_page = 2;
    global $connection;
    if (empty($column)) {
        $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT {$offset}, {$per_page} ";
    } else {
        $query = "SELECT * FROM posts WHERE post_status = 'published' AND {$column} = {$value} ORDER BY post_id DESC LIMIT {$offset}, {$per_page} ";
    }
    $select_all_posts = mysqli_query($connection, $query);
    $post_count = getPostCount($column, $value);
    $pages = ceil($post_count/$per_page);
    if($post_count > 0) {
        getPosts($select_all_posts);
    } else {
        echo "<h1>No posts!</h1>";
    }
    return $pages;
}
function pagination($pages) {
    for($i=1; $i<=$pages; $i++) {
        echo "<a href='index.php?page={$i}'>{$i}</a>";
    }
}
function calcOffset() {
    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = "";
    }
    if($page == "" || $page == 1) {
        $offset = 0; 
    } else {
        $offset = ($page * 2) - 2;
    }
    return $offset;
}
?>