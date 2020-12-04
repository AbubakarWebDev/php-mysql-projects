<?php 
    if (isset($_POST['checkUpdate'])) {

        include "config.php";

        $sql = "UPDATE student SET name = '{$_POST['name']}', address = '{$_POST['address']}', phone = '{$_POST['phone']}', class = '{$_POST['class']}' WHERE id = {$_POST['id']};";
        
        mysqli_query($connection, $sql) or die("Query Unsuccessfull");

        header("Location: index.php");
    }
?>