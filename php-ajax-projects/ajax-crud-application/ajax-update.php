<?php

   include_once "config.php"; 

   $id = $_POST["ID"];
   $name = $_POST["name"];
   $phone = $_POST["phone"];
   $percentage = $_POST["percentage"];
   $address = $_POST["address"];

   $sql = "UPDATE person SET name = '{$name}', phone = '{$phone}', percentage = '{$percentage}', address = '{$address}' WHERE id = {$id};";

   echo (mysqli_query($connection, $sql))? true: false;
   mysqli_close($connection);

?>
