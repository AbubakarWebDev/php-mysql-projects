<?php

   include_once "config.php"; 
   $sql = "SELECT * FROM person WHERE name LIKE '%{$_POST["search"]}%'";
   $output = "";

   if ($result = mysqli_query($connection, $sql)) 
   {
       if(mysqli_num_rows($result) > 0) 
       {
           while($row = mysqli_fetch_array($result)) 
           {
               $output .= 
               "<tr>
                    <th>{$row['ID']}</th>
                    <td>{$row['name']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['address']}</td>
                    <td><button data-id='{$row['ID']}' type='button' data-toggle='modal' data-target='#updateModal' class='edit-btn font-weight-bolder w-100 btn btn-dark'>Edit</button></td>
                    <td><button data-id='{$row['ID']}' type='button' class='delete-btn font-weight-bolder w-100 btn btn-dark'>Delete</button></td>
                </tr>";               
           }
        }

        mysqli_close($connection);
        echo $output;
   }
   else {
        echo $output;
   }

?>