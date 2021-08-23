<?php 
    if (isset($_POST['checkUpdate'])) {

        include "config.php";

        $sql = "UPDATE student SET stu_name = '{$_POST['name']}', stu_address = '{$_POST['address']}', stu_phone = '{$_POST['phone']}', course_id = '{$_POST['course']}' WHERE stu_id = {$_POST['id']};";
        
        mysqli_query($connection, $sql) or die("Query Unsuccessfull");

        header("Location: index.php");
    }
?>