<?php 

    if (!isset($_SESSION["user"])) {
        header("Location: index.php");
    }

    if (isset($_GET['post_id']) && isset($_GET['category_id'])) {

        include_once "config.php";

        $sql = "SELECT post_img FROM post WHERE post_id = {$_GET['post_id']};";

        if ($result = mysqli_query($connection, $sql)) 
        {
            if(mysqli_num_rows($result) > 0) 
            {
                $row = mysqli_fetch_array($result);

                unlink("uploads/{$row["post_img"]}");
            }
        }
        else {
            die("Query Unsuccessfull"); 
        } 

        $sql = "DELETE FROM post WHERE post_id = {$_GET['post_id']};";
        $sql .= "UPDATE category SET no_of_post = no_of_post - 1 WHERE category_id = {$_GET['category_id']};";
        
        if (mysqli_multi_query($connection, $sql)) {
            header("Location: post.php");
        }
        else {
            die("Query Unsuccessfull"); 
        } 
    }
    else {
        header("Location: post.php");
    }

?>