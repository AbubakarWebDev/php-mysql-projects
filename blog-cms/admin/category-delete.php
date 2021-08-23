<?php 
    if (!isset($_SESSION["user"])) {
        header("Location: index.php");
    }

    if ($_SESSION["user"]["user_role"] == "subscriber") {
        header("Location: post.php");
    }

    if (isset($_GET['category_id'])) 
    {
        include_once "config.php";

        $sql = "DELETE FROM category WHERE category_id = {$_GET['category_id']};";
        
        if (mysqli_query($connection, $sql)) {
            header("Location: category.php");
        }
        else {
            die("Query Unsuccessfull"); 
        } 
    }
    else {
        header("Location: post.php");
    }
?>