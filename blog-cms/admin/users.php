<?php 
    include_once "header.php";

    if ($_SESSION["user"]["user_role"] == "subscriber") {
        header("Location: post.php");
    }
?>

<div class="container-lg container-fluid" style="margin:100px auto; min-height: 55.3vh;">
    <div class="row mb-2 align-items-center justify-content-between">
        <hr class="mb-2">
        <div class="col-6" style="font-family: anton">
            <h1 class="text-uppercase mb-0">All Users</h1>
        </div>
        <div class="col-6 text-right">
            <a href="add-user.php" class="btn btn-danger btn-lg">Add User</a>
        </div>
        <hr class="mt-2 mb-4">
    </div>
    
    <?php 
        $limit = 3;
        $page_no = isset($_GET["page_no"])? $_GET["page_no"] : 1;
        $offset = ($page_no - 1) * $limit;

        $sql = "SELECT user_id, username, first_name, last_name, user_role FROM users WHERE status = 'verified' ORDER BY user_id DESC LIMIT {$offset}, {$limit}";

        if ($result = mysqli_query($connection, $sql)) 
        {
            if(mysqli_num_rows($result) > 0) 
            {
                echo '
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="table-dark">
                                <th>User No</th>
                                <th>Full Name</th>
                                <th>User Name</th>
                                <th>User Role</th>
                                <th>User Edit</th>
                                <th>User Delete</th>
                            </tr>
                        </thead>
                        <tbody>';

                        $serial_no = $offset + 1;
                        while($row = mysqli_fetch_array($result)) {
                            echo "
                            <tr>
                                <th>{$serial_no}</th>
                                <td>{$row['first_name']} {$row['last_name']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['user_role']}</td>

                                <td><a href='user-edit.php?user_id={$row['user_id']}'><i class='fas fa-edit'></i></a></td>";

                                $sql_admin = "SELECT user_id FROM users WHERE user_role = 'admin' AND status = 'verified'";

                                if ($result_admin = mysqli_query($connection, $sql_admin)) 
                                {
                                    if (mysqli_num_rows($result_admin) == 1)
                                    {
                                        $row_admin = mysqli_fetch_array($result_admin);
                        
                                        if ($row['user_id'] == $row_admin['user_id'])
                                        {
                                            echo "<td><a href='#' onclick=\"alert('You Must Need One Admin. So this user account cannot be deleted')\" ><i class='fas fa-trash-alt'></i></a></td>
                                            </tr>"; 
                                        }
                                        else {
                                            echo "<td><a href='user-delete.php?user_id={$row['user_id']}'><i class='fas fa-trash-alt'></i></a></td>
                                            </tr>";
                                        }
                                    }
                                    else {
                                        echo "<td><a href='user-delete.php?user_id={$row['user_id']}'><i class='fas fa-trash-alt'></i></a></td>
                                        </tr>";
                                    }
                                }
                                $serial_no++;
                        };
                        echo '
                        </tbody>
                    </table>
                </div>';
            }
            else {
                echo "<h3 class='text-center my-4'>Nothing to Show Here. No User Record is Present on Database</h3>";
            }
        }
        else {
            echo "<p>Query Unsuccessfull</p>";
        }

        echo "<div class='row mt-4 pagination'>
        <div class='col-12 d-flex align-items-center justify-content-center'>";

        $sql = "SELECT * FROM users";

        if ($result = mysqli_query($connection, $sql)) 
        {
            if(mysqli_num_rows($result) > 0) {
                $total_records = mysqli_num_rows($result);
                $total_pages = ceil($total_records / $limit);
                $next_page = $page_no + 1;
                $prev_page = $page_no - 1;
                $active = "";

                if ($page_no > 1) {
                    echo "<span><a href='users.php?page_no={$prev_page}'><i class='fas fa-angle-left'></i></a></span>";
                }

                for ($i=1; $i <= $total_pages; $i++) {
                    if ($i == $page_no) {
                        $active = "active";
                    }
                    else {
                        $active = "";
                    }
                    echo "<span class='$active'><a href='users.php?page_no=$i'>$i</a></span>";
                }

                if ($page_no > 3) {
                    echo "
                        <div>....</div>
                        <span><a href='users.php?page_no={$total_pages}'>$total_pages</a></span>";                           
                }
                
                if ($page_no != $total_pages) {
                    echo "<span><a href='users.php?page_no={$next_page}'><i class='fas fa-angle-right'></i></a></span>";
                }
            }
            echo "</div></div>";
        }
        else {
            echo "<script>alert('Query Unsuccessfull')</script>";
        }
    ?>

</div>

<?php include_once "footer.php" ?>