<?php

   include_once "config.php"; 
   $sql = "SELECT * FROM person WHERE ID = {$_POST['studentId']}";
   $output = "";

   if ($result = mysqli_query($connection, $sql))
   {
       if(mysqli_num_rows($result) > 0) 
       {
           $row = mysqli_fetch_array($result);
            $output .= 
            "<input id='updateId' type='hidden' value='{$row['ID']}'>
            <div class='form-group'>
                <label for='updateName'>Name</label>
                <input type='text' class='form-control' id='updateName' placeholder='Enter Name' required value='{$row['name']}'>
            </div>
            <div class='form-group'>
                <label for='updatePhone'>Phone</label>
                <input type='text' class='form-control' id='updatePhone' placeholder='Enter Phone' required value='{$row['phone']}'>
            </div>
            <div class='form-group'>
                <label for='updateAddress'>Address</label>
                <input type='text' class='form-control' id='updateAddress' placeholder='Enter Address' required value='{$row['address']}'>
            </div>";               
        }

        mysqli_close($connection);
        echo $output;
   }
   else {
       echo $output;
   }

?>