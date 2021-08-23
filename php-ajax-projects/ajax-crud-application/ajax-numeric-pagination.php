<?php

   include_once "config.php";
   
   $limit = 3;
   $total_records = 0;
   $page_no = (isset($_POST["page_no"]))? $_POST["page_no"] : 1;
   $offset = ($page_no - 1) * $limit;
   
   $sql = "SELECT * FROM person LIMIT $offset, $limit";
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
          </div>
          <div class='row my-4 pagination'>
               <div class='col-12 d-flex justify-content-center'>";

          $sql = "SELECT * FROM person";
          if ($result = mysqli_query($connection, $sql)) {
               $total_records = mysqli_num_rows($result);
          }

          $total_pages = ceil($total_records / $limit);
          $next_page = $page_no + 1;
          $prev_page = $page_no - 1;
          $active = "";

          if ($page_no > 1) {
               $output.=  "<span id='$prev_page'><i class='fas fa-angle-left'></i></span>";
          }

          for ($i=1; $i <= $total_pages; $i++) 
          {
               $active = ($i == $page_no)? "active" : "";
               $output.= "<span class='$active' id='$i'>$i</span>";
          }
          
          if ($page_no < $total_pages) {
               $output.= "<span id='$next_page'><i class='fas fa-angle-right'></i></span>";
          }

          $output .= "</div></div>";
     }

     mysqli_close($connection);
     echo $output;
   }
   else {
        echo $output;
   }

?>