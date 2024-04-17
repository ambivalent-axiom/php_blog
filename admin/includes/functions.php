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

function getAuthorByPost($author) {
    global $connection;
    $query = "SELECT * FROM users WHERE user_id = $author ";
    $select_author = mysqli_query($connection, $query);
    while($author = mysqli_fetch_assoc($select_author)) {
        return($author['user_name']);
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
    checkQuery($increment_com);
}

function checkIfExists($column, $value) {
    global $connection;
    $query = "SELECT * FROM users WHERE {$column} = '{$value}' ";
    $exec_query = mysqli_query($connection, $query);
    checkQuery($exec_query);
    if(mysqli_num_rows($exec_query) == 0) {
        return false;
    } else {
        return true;
    }
}

function encryptPass($pass) {
    global $connection;
    $query = "SELECT randSalt FROM users";
    $select_randsalt = mysqli_query($connection, $query);
    checkQuery($select_randsalt);
    $row = mysqli_fetch_array($select_randsalt);
    $salt = $row['randSalt'];
    return $encrypted_pass = crypt($pass, $salt); 
}
?>