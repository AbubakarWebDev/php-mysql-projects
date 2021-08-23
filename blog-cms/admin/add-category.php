<?php     
    include_once "header.php";

    if ($_SESSION["user"]["user_role"] == "subscriber") {
        header("Location: post.php");
    }
?>

<div style="margin-bottom: 242px" class="mt-5 container-lg container-fluid">
    <h3 class="text-center">ADD CATEGORY RECORDS</h3>
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
    
        $category = $category_error = "";

        if ((isset($_POST['add_category']))) {

            if (empty($_POST["category"])) {
                $category = "<b class='text-danger'>* This Field is Required</b>";
            }
            else {
                
                $category = convert_input($_POST["category"]);
                
                if (!preg_match("/^[a-zA-Z ]{3,50}$/", $category)) {
                    $category_error = "<b class='text-danger'>First Name Contains At Least 3 characters and at most 50 characters Allowed. No Special & numeric Characters is Allowed</b>";
                }
                else {

                    $sql = "SELECT * FROM category WHERE category_name = '{$category}'";

                    if ($result = mysqli_query($connection, $sql)) {
                        if(mysqli_num_rows($result) > 0) 
                        {
                            $category_error = "<b class='text-danger'> Category is already registered. Please Try Different Category.</b>";
                        }  
                    }
                    else {
                        echo "<script>alert('Query Unsuccessfull');</script>";
                    }
                }
            }
        }
    ?>

    <div class="form-container mt-5">
        <div id="message"></div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <div class="mb-3 row">
                <label class="col-lg-3 col-form-label">Category Name: </label>
                <div class="col-lg-9">
                    <input type="text" name="category" class="form-control" placeholder="Category Name" value="<?php echo $category ?>" required>
                    <?php echo $category_error ?>
                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" name="add_category" class="btn btn-lg btn-primary font-weight-bolder">ADD CATEGORY RECORD</button>
            </div>
        </form>
    </div>
</div>

<?php
    include_once "footer.php";

    echo "<script>";

    if (isset($_POST['add_category'])) {

        if (empty($category_error)) {

            $sql = "INSERT INTO category (category_name) VALUES ('{$category}');";
        
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