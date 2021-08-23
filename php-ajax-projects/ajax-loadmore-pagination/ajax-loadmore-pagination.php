<?php
     include_once "config.php";

     $limit = 3;
     $offset = (isset($_POST["offset"]))? $_POST["offset"] : 0;
     
     $sql = "SELECT * FROM person LIMIT $offset, $limit";                   
     $output = "";
     
     $result = mysqli_query($connection, $sql) or die("Query Unsuccessfull: " . mysqli_error($connection));
     
     if(mysqli_num_rows($result) > 0) 
     {
          $output .= "<tbody>";
          while($row = mysqli_fetch_array($result)) {
               $output .= 
               "<tr>
                    <td>{$row['ID']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['address']}</td>
               </tr>";   
               $offset++;       
          }

          $output.= 
          "</tbody>
          <tbody id='pagination'>
               <tr class='text-center'>
                    <td colspan='5'>
                         <button id='loadBtn' data-id='{$offset}' class='btn btn-lg btn-dark font-weight-bolder px-5'>Loading...</button>
                    </td>
               </tr>
          </tbody>";

          echo $output;
     }
     else 
     {
          echo $output;
     }

     mysqli_close($connection);
?>