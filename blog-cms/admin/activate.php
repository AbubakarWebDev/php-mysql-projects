<?php
   if (isset($_GET['token'])) 
   {
      session_start();   
      include_once 'config.php';
      $sql = "SELECT token FROM users WHERE token = '{$_GET['token']}'";

      if ($result = mysqli_query($connection, $sql)) {
         if(!mysqli_num_rows($result)) {
            $_SESSION["account_verification-msg"] = [
               "status" => "danger",
               "msg" => "Your Account is Not Verified. Please Check Your Mail and Verified It. You Should Need Verified Account for Login"
            ];
            header("Location: index.php");
         }
      }
      else {
         echo "<script>alert('Query Unsuccessfull')</script>";
      }
      
      $sql = "UPDATE users SET status = 'verified' WHERE token = '{$_GET['token']}'"; 
      
      if (mysqli_query($connection, $sql)) {
         $_SESSION["account_verification_msg"] = [
            "status" => "success",
            "msg" => "Your Account is Verified Successfully. Please Login Account"
         ];
         header("Location: index.php");
      }
      else {
         echo "<script>alert('Query Unsuccessfull')</script>";
      }
   }
   else {
      header("Location: index.php");
   }
?>