<?php

    if (!isset($_SESSION["user"])) {
        header("Location: index.php");
    }

    if ($_SESSION["user"]["user_role"] == "subscriber") {
        header("Location: post.php");
    }

    if (isset($_GET['user_id'])) {

        session_start();
        
        include_once "config.php";

        $sql = "SELECT user_id FROM users WHERE user_role = 'admin' AND status = 'verified'";

        if ($result = mysqli_query($connection, $sql)) 
        {
            if (mysqli_num_rows($result) == 1)
            {
                $row = mysqli_fetch_array($result);

                if ($_GET['user_id'] != $row['user_id']) {

                    $sql = "DELETE FROM users WHERE user_id = {$_GET['user_id']};";
        
                    mysqli_query($connection, $sql) or die("Query Unsuccessfull");
                    
                    if ($_GET['user_id'] == $_SESSION["user"]["user_id"]) {
                        header("Location: logout.php");
                    }
                    else {
                        header("Location: users.php");
                    }
                }
                else {
                    header("Location: users.php");
                }
            }
            else 
            {
                $sql = "DELETE FROM users WHERE user_id = {$_GET['user_id']};";
        
                mysqli_query($connection, $sql) or die("Query Unsuccessfull");
                
                if ($_GET['user_id'] == $_SESSION["user"]["user_id"]) {
                    header("Location: logout.php");
                }
                else {
                    header("Location: users.php");
                }
            }
        }
        else {
            echo "<script>alert('Query Unsuccessfull')</script>";
        }
    }
    else {
        header("Location: index.php");
    }
?>