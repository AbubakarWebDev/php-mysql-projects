<?php

    if (isset($_GET['token'])) {
    
       session_start();
       
       include 'config.php';

       $sql = "UPDATE signup SET validity = 'valid' WHERE token = '{$_GET['token']}'"; 

       if (mysqli_query($connection, $sql)) {
               $_SESSION["message"] = "Your Account is Verified Successfully. Please Login Account";
               header("Location: admin.php");
       }
       else {
            $_SESSION["message"] = "Your Account is Not Verified. Please Signup Again";
            header("Location: registration.php");
       }
    }
?>