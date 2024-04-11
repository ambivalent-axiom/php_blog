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

function deletePost() {
    global $connection;
    if(isset($_GET['delete'])) {
        $post_to_delete = $_GET['delete'];
        $clear_com_quer = "DELETE FROM comments WHERE com_post_id = $post_to_delete ";
        $query = "DELETE FROM posts WHERE post_id = {$post_to_delete} ";
        $clear_comments = mysqli_query($connection, $clear_com_quer);
        checkQuery($clear_comments);
        $execure_query = mysqli_query($connection, $query);
        checkQuery($execure_query);
        header("Location: posts.php");
    }
}

function checkQuery($query) {
    global $connection;
    if(!$query) {
        die("Query Failed: " . mysqli_error($connection));
    }
}


?>