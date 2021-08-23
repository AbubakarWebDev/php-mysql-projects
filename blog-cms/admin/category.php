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
            <h1 class="text-uppercase mb-0">All Categories</h1>
        </div>
        <div class="col-6 text-right">
            <a href="add-category.php" class="btn btn-danger btn-lg">Add Category</a>
        </div>
        <hr class="mt-2 mb-4">
    </div>


    <?php 
        $limit = 3;
        $page_no = isset($_GET["page_no"])? $_GET["page_no"] : 1;
        $offset = ($page_no - 1) * $limit;

        $sql = "SELECT category_id, category_name, no_of_post FROM category ORDER BY category_id DESC LIMIT {$offset}, {$limit}";

        if ($result = mysqli_query($connection, $sql)) 
        {
            if(mysqli_num_rows($result) > 0) 
            {
                echo '
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr class="table-dark">
                                <th>Category No</th>
                                <th>Category Name</th>
                                <th>No of Post</th>
                                <th>Category Edit</th>
                                <th>Category Delete</th>
                            </tr>
                        </thead>
                        <tbody>';

                        $serial_no = $offset + 1;
                        while($row = mysqli_fetch_array($result)) {
                            echo "
                            <tr>
                                <th>{$serial_no}</th>
                                <td>{$row['category_name']}</td>
                                <td>{$row['no_of_post']}</td>
                                <td><a href='category-edit.php?category_id={$row['category_id']}'><i class='fas fa-edit'></i></a></td>
                                <td><a href='category-delete.php?category_id={$row['category_id']}'><i class='fas fa-trash-alt'></i></a></td>
                            </tr>";
                            $serial_no++;
                        };

                        echo '
                        </tbody>
                    </table>
                </div>';
            }
            else {
                echo "<h3 class='text-center my-4'>Nothing to Show Here. No Category Record is Present on Database</h3>";
            }
        }
        else {
            echo "<p>Query Unsuccessfull</p>";
        }

        echo "<div class='row mt-4 pagination'>
        <div class='col-12 d-flex align-items-center justify-content-center'>";

        $sql = "SELECT * FROM category";

        if ($result = mysqli_query($connection, $sql)) 
        {
            if(mysqli_num_rows($result) > 0) {
                $total_records = mysqli_num_rows($result);
                $total_pages = ceil($total_records / $limit);
                $next_page = $page_no + 1;
                $prev_page = $page_no - 1;
                $active = "";

                if ($page_no > 1) {
                    echo "<span><a href='category.php?page_no={$prev_page}'><i class='fas fa-angle-left'></i></a></span>";
                }

                for ($i=1; $i <= $total_pages; $i++) {
                    if ($i == $page_no) {
                        $active = "active";
                    }
                    else {
                        $active = "";
                    }
                    echo "<span class='$active'><a href='category.php?page_no=$i'>$i</a></span>";
                }

                if ($page_no > 3) {
                    echo "
                        <div>....</div>
                        <span><a href='category.php?page_no={$total_pages}'>$total_pages</a></span>";                            
                }
                
                if ($page_no != $total_pages) {
                    echo "<span><a href='category.php?page_no={$next_page}'><i class='fas fa-angle-right'></i></a></span>";
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