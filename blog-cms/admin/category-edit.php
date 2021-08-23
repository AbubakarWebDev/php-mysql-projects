<?php 
    include_once "header.php";

    if ($_SESSION["user"]["user_role"] == "subscriber") {
        header("Location: post.php");
    }

?>

<div style="margin-bottom: 242px" class="mt-5 container-lg container-fluid">
    <h3 class="text-center">UPDATE CATEGORY RECORDS</h3>
    <center>
        <hr style="width:15%">
    </center>

    <?php 
        function convert_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            $data = mysqli_real_escape_string($GLOBALS["connection"], $data);
            return $data;
        }
    
        $category_id = $category_name = $category_name_error = $old_category_name = "";

        if ((isset($_POST['update_category']))) {

            $category_id = $_POST["category_id"];

            if (empty($_POST["category"])) {
                $category_name_error = "<b class='text-danger'>* This Field is Required</b>";
            }
            else {
                $category_name = convert_input($_POST["category"]);
                
                if (!preg_match("/^[a-zA-Z ]{3,100}$/", $category_name)) {
                    $category_name_error = "<b class='text-danger'>First Name Contains At Least 3 characters and at most 100 characters Allowed. No Special & numeric Characters is Allowed</b>";
                }
                else {
                    $sql = "SELECT category_name FROM category WHERE $category_id = '$category_id'";
                    
                    if ($result = mysqli_query($connection, $sql))
                    {
                        if (mysqli_num_rows($result) > 0) 
                        {
                            $row = mysqli_fetch_array($result);

                            $old_category_name = $row["category_name"];

                            $sql = "SELECT category_name FROM category";
                            $db_category_arr = []; 
                    
                            if ($result = mysqli_query($connection, $sql))
                            {
                                if (mysqli_num_rows($result) > 0) 
                                {
                                    while ($row = mysqli_fetch_array($result)) {
                                        array_push($db_category_arr, $row["category_name"]);
                                    }
                                }
                            }
                            else {
                                echo "<script>alert('Query Unsuccessfull')</script>";
                            }

                            array_splice($db_category_arr, array_search($old_category_name, $db_category_arr), 1);

                            if (in_array($category_name, $db_category_arr)) {
                                $category_name_error = "<b class='text-danger'> category is already registered. Please Try Different category.</b>";  
                            }
                        }   
                    } 
                    else {
                        echo "<script>alert('Query Unsuccessfull')</script>";
                    }
                }
            }
        }

        $row = [];

        if (isset($_GET['category_id'])) {

            $sql = "SELECT category_name FROM category WHERE category_id = '{$_GET['category_id']}'";

            if ($result = mysqli_query($connection, $sql)) 
            {
                if(mysqli_num_rows($result) > 0) 
                {
                    $row = mysqli_fetch_array($result);
                }
            }
        }
    
    ?>

    <div class="form-container mt-5">
        <div id="message"></div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">

            <input type="hidden" name="category_id" value="<?php echo isset($_GET["category_id"])? $_GET["category_id"] : $category_id ?>">

            <div class="mb-3 row">
                <label class="col-lg-3 col-form-label">Category Name: </label>
                <div class="col-lg-9">
                    <input type="text" name="category" class="form-control" placeholder="Category Name" value="<?php echo isset($row["category_name"])? $row["category_name"] : $category_name ?>" required>
                    <?php echo $category_name_error ?>
                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" name="update_category" class="btn btn-lg btn-primary font-weight-bolder">UPDATE CATEGORY RECORD</button>
            </div>
        </form>
    </div>
</div>

<?php
    include_once "footer.php";

    echo "<script>";

    if (isset($_POST['update_category'])) {

        if (empty($category_name_error)) {

            $sql = "UPDATE category SET category_name = '{$category_name}' WHERE category_id = '{$category_id}';";
        
            if (mysqli_query($connection, $sql)) {
                header("Location: category.php");
            }
            else {
                echo "alert('Query Unsuccessfull')";
            }
        }
        else {
            echo "showMessage('#message', 'danger', 'Error!', 'Some Error Occured. Please Try Again!');"; 
        }
    }

    echo "</script>";  
?>