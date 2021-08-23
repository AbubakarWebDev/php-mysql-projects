<?php

   include_once "config.php";
   $sql = "DELETE FROM person WHERE ID = {$_POST['studentId']}";

   echo (mysqli_query($connection, $sql))? true: false;
   mysqli_close($connection);

?>