<?php
   
   include_once "config.php"; 

   $name = $_POST["name"];
   $phone = $_POST["phone"];
   $address = $_POST["address"];

   $sql = "INSERT INTO person (name, phone, address) VALUES ('{$name}', '{$phone}', '{$address}')";

   echo (mysqli_query($connection, $sql))? true: false;
   mysqli_close($connection);

?>