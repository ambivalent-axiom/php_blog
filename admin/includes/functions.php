<?php
    //dependencies
    require 'phpmailer/Exception.php';
    require 'phpmailer/PHPMailer.php';
    require 'phpmailer/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;



//CATEGORY MANAGEMENT
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
//SECURITY
function encryptPass(string $pass, int $cost=10): string {
    $encrypted_pass = password_hash($pass, PASSWORD_BCRYPT, array('cost' => $cost));
    return $encrypted_pass;
}
function escape(string $string): string {//use this before sending string to database
    global $connection;
    $stripScript = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    return mysqli_real_escape_string($connection, trim($stripScript));
}
function checkQuery($query) {
    global $connection;
    if(!$query) {
        die("Query Failed: " . mysqli_error($connection));
    }
}
//POSTS MANAGEMENT
//Comments
function addComment($post_id, $com_auth, $com_email, $comment) {
    global $connection;
    $query = "INSERT INTO comments (com_post_id, com_author, com_email, com_content, com_date) " .
    "VALUES ({$post_id}, '{$com_auth}', '{$com_email}', '{$comment}', now()) ";
    $save_comm = mysqli_query($connection, $query);
    checkQuery($save_comm);
}
function getCommentCount($post_id) {
    global $connection;
    $query = "SELECT * FROM comments WHERE com_post_id = {$post_id} ";
    $comments = mysqli_query($connection, $query);
    checkQuery($comments);
    return mysqli_num_rows($comments);
}
function getComments(string $status='approved', int $post_id): void {
    global $connection;
    $query = "SELECT * FROM comments WHERE com_status = '$status' AND com_post_id = $post_id ORDER BY com_id DESC ";
    $get_comments = mysqli_query($connection, $query);
    checkQuery($get_comments);

    while($comment = mysqli_fetch_assoc($get_comments)) {
        $author = $comment['com_author'];
        $email = $comment['com_email'];
        $date = $comment['com_date'];
        $content = $comment['com_content'];
        $user = checkIfExists('user_email', $email, 'get_id');

        if(!empty($user)) {
            $image = getAuthorByPost($user, 'image');
        }
    ?>
        <div class="media">
            <img class="media-object pull-left" src="/cms/images/user/user.png" alt="" height='40'>

            <div class="media-body">
                <h4 class="media-heading"><?php echo $author ?>
                    <small><?php echo $date ?></small>
                    <small><?php echo $email ?></small>
                </h4>
                    <?php echo $content ?>
            </div>
        </div>
    <?php
    }
}
//actions
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
function getAllPosts($access) {
    global $connection;
    if($access === 'admin') {
        $query = "SELECT * FROM posts ORDER BY post_id DESC ";
        $all_posts = mysqli_query($connection, $query);
        return $all_posts;
    } else {
        $query = "SELECT * FROM posts WHERE post_author = {$access} ORDER BY post_id DESC ";
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
                <?php echo $blog_post_title ?>
            </a>
        </h2>
        <p class='lead'>by
            <a href='user.php?u_id=<?php echo $blog_post_author ?>'>
                <?php echo $author_name ?>
            </a>
        </p>
        <p>
            <span class='glyphicon glyphicon-time'></span> 
                Posted on <?php echo $blog_post_date ?>
                | Comments: <?php echo getCommentCount($blog_post_id) ?>
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
function deletePost($post_to_delete) {
    global $connection;
    $clear_com_quer = "DELETE FROM comments WHERE com_post_id = $post_to_delete ";
    $query = "DELETE FROM posts WHERE post_id = {$post_to_delete} ";
    $clear_comments = mysqli_query($connection, $clear_com_quer);
    checkQuery($clear_comments);
    $execure_query = mysqli_query($connection, $query);
    checkQuery($execure_query);
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
//This lists posts on index page + pagination
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
function showPostsPaginated($column="", $value="", $offset) {//$per_page for settings
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
        if(isset($_GET['page']) && $i == $_GET['page']) {
            echo "<a href='index.php?page={$i}' style='color:#fff; background-color:#554c66'>{$i}</a>";
        } else {
            echo "<a href='index.php?page={$i}'>{$i}</a>";
        }
        
    }
}
function calcOffset() {//$per_page for settings
    $per_page = 2;
    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = "";
    }
    if($page == "" || $page == 1) {
        $offset = 0; 
    } else {
        $offset = ($page * $per_page) - $per_page;
    }
    return $offset;
}
//USER MANAGEMENT
function onlineRegister() {//$user_session_timeout for settings page
    global $connection;
    $session = session_id();
    $user_id = $_SESSION['id'];
    $time = time();
    $user_session_timeout = 120;
    $time_out = $time - $user_session_timeout;

    //check if my session is logged into database
    $query = "SELECT * FROM users_online WHERE session = '{$session}'";
    $exec_query = mysqli_query($connection, $query);
    checkQuery($exec_query);
    $count = mysqli_num_rows($exec_query);

    if($count == 0) {
        $query = "INSERT INTO users_online (session, time, user_id) VALUES('$session', '$time', $user_id) ";
        $exec_query = mysqli_query($connection, $query);
        checkQuery($exec_query);
    } else {
        $query = "UPDATE users_online SET time = '{$time}' WHERE session = '$session' ";
        $exec_query = mysqli_query($connection, $query);
        checkQuery($exec_query);
    }
    return $time_out;
}
function countUsrsOn() {
    global $time_out;
    global $connection;
    $users_online = mysqli_query($connection, "SELECT * FROM users_online  WHERE time > '$time_out' ");
    checkQuery($users_online);
    return $users_online;
}
function countAjax() {
    if(isset($_GET['onlineusers'])) {//echos number directly for ajax
        include '../../includes/db.php';
        $time = time();
        $user_session_timeout = 120;
        $time_out = $time - $user_session_timeout;
        $users_online = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");
        checkQuery($users_online);
        $result = mysqli_num_rows($users_online);
        echo $result;
    }
}
countAjax();//execution for ajax

function fetchAndPrint($users) {
    global $time_out;
    while($row = mysqli_fetch_assoc($users)) {
        $id = $row['user_id'];
        $name = $row['user_name'];
        $firstnm = $row['user_fn'];
        $lastnm = $row['user_ln'];
        $email = $row['user_email'];
        $image = $row['user_image'];
        $role = $row['user_role'];
        $online = [];
        foreach(countUsrsOn($time_out) as $user) {
            array_push($online, $user['user_id']);
        };
        ?>  <tr>
                <td><?php echo $id ?></td>
                <td><?php echo $name ?></td>
                <td><?php echo $firstnm . " " . $lastnm ?></td>
                <td><?php echo $email ?></td>
                <td><img src="../images/user/<?php echo $image ?>" alt="" height="40"></td>
                <td><?php echo $role ?></td>
                <td><?php
                    if(in_array($id, $online)) {
                        echo "Online";
                    } else {
                        echo "Offline";
                    }
                ?></td>
                <td><a href="?source=edit&u_id=<?php echo $id ?>">Edit</a> | 
                    <a href="?source=del&u_id=<?php echo $id ?>">Delete</a>
                </td>
            </tr>
        <?php
    }
}
function getUsers() {
    global $connection;
    $query = "SELECT * FROM users ";
    $all_users = mysqli_query($connection, $query);
    fetchAndPrint($all_users);
}
function getUsersOnline($time_out) {
    global $connection;
    $online = countUsrsOn($time_out);
    foreach($online as $user) {
        $get_user = getUserById($user['user_id']);
        fetchAndPrint($get_user);
    }
}
function getUserLnFn() {//takes $_SESSION
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
function deleteUser(int $user_id): void {
    global $connection;
    $query = "DELETE FROM users WHERE user_id = {$user_id} ";
    $exec_query = mysqli_query($connection, $query);
    checkQuery($exec_query);
}
function getUserById(int $user_id): mysqli_result {
    global $connection;
    $query = "SELECT * FROM users WHERE user_id = {$user_id} ";
    $get_user = mysqli_query($connection, $query);
    checkQuery($get_user);
    return $get_user;
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
//emailing and messaging
function sendEmailNotification(string $from, string $subject, string $content): void {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        //$mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host       = 'mail.inbox.lv';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ambax.io@inbox.lv';
        $mail->Password   = 'JapsTQ786R';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('ambax.io@inbox.lv', $from);
        $mail->addAddress('artmelnis@gmail.com');

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $content;
        $mail->send();
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}
?>
