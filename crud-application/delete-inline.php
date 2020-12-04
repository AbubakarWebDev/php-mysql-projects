<?php 
    if (isset($_GET['id'])) {

        include "config.php";
                    
        $sql = "DELETE FROM student WHERE id = {$_GET['id']};";

        mysqli_query($connection, $sql) or die("Query Unsuccessfull");
        
        header("Location: index.php");
    }
?>