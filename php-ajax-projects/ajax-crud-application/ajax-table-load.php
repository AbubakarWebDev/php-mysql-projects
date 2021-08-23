<?php

   include_once "config.php";    
   $sql = "SELECT * FROM person";
   $output = "";
   
     if ($result = mysqli_query($connection, $sql)) 
     {
          if(mysqli_num_rows($result) > 0) 
          {
               $output .= 
               "<div class='table-responsive'>
                    <table class='table table-bordered'>
                         <thead class='thead-dark'>
                              <tr>
                                   <th>ID</th>
                                   <th>Name</th>
                                   <th>Phone</th>
                                   <th>Address</th>
                                   <th>Edit</th>
                                   <th>Delete</th>
                              </tr>
                         </thead>
                         <tbody id='table-body'>";

               while($row = mysqli_fetch_array($result)) 
               {
                    $output .= 
                    "<tr>
                         <td>{$row['ID']}</td>
                         <td>{$row['name']}</td>
                         <td>{$row['phone']}</td>
                         <td>{$row['address']}</td>
                         <td><button data-id='{$row['ID']}' type='button' data-toggle='modal' data-target='#updateModal' class='edit-btn font-weight-bolder w-100 btn btn-dark'>Edit</button></td>
                         <td><button data-id='{$row['ID']}' type='button' class='delete-btn font-weight-bolder w-100 btn btn-dark'>Delete</button></td>
                    </tr>";            
               }
               
               $output.= 
               "         </tbody>
                    </table>
               </div>";

               mysqli_close($connection);
               echo $output;
          }
          else {
               echo $output;
          }
     }
?>