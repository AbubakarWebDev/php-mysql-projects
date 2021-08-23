<?php include_once "header.php"; ?>

<div class="my-5 pb-3 container-lg container-fluid">
    <h3 class="text-center">ADD BLOG POST</h3>
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

        $post_title = $post_category = $post_img = $post_description = $post_author = "";
        $post_title_error = $post_category_error = $post_img_error = $post_description_error = ""; 

        if ((isset($_POST['add_post']))) {

            if (empty($_POST["post_title"])) {
                $post_title_error = "<b class='text-danger'>* This Field is Required</b>";
            }
            else {
                $post_title = convert_input($_POST["post_title"]);
                
                if (!(strlen($post_title) >= 6 && strlen($post_title) <= 90)) {
                    $post_title_error = "<b class='text-danger'>Post Title Contains At Least 6 characters and at most 90 characters Allowed.</b>";
                }
            }

            if (empty($_POST["post_category"])) {
                $post_category_error = "<b class='text-danger'>* This Field is Required</b>";
            }
            else {
                $post_category = convert_input($_POST["post_category"]);
            }

            if (empty($_POST["post_description"])) {
                $post_description_error = "<b class='text-danger'>* This Field is Required</b>";
            }
            else {
                $post_description = $_POST["post_description"];
                
                if (!(strlen($post_description) >= 50 && strlen($post_description) <= 2500)) {
                    $post_description_error = "<b class='text-danger'>Post Description Contains At Least 50 characters and at most 2500 characters Allowed.</b>";
                }
            }

            include_once "upload.php";

            $file = $_FILES["post_img"];
            $file_allowed_extensions = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $file_maximum_allowed_size = 5 * 1024 * 1024;   // 5 MB 
            $file_upload_directory = "uploads";

            $files_arr = validateFile($file, $file_maximum_allowed_size, $file_allowed_extensions, $file_upload_directory, $post_img_error);

            $post_img = $files_arr[0];
        }
    ?>

    <div class="form-container mt-5">
        <div id="message"></div>
        <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">Post Title: </label>
                <div class="col-md-9">
                    <input type="text" name="post_title" class="form-control" placeholder="Post Title" value="<?php echo $post_title ?>" required>
                    <?php echo $post_title_error ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">Category: </label>
                <div class="col-md-9">
                    <select name="post_category" class="form-select" required>
                        <option value="">Select Category</option>
                        <?php                            
                            $sql = "SELECT * FROM category";
                            
                            if ($result = mysqli_query($connection, $sql)) 
                            {
                                if(mysqli_num_rows($result) > 0) 
                                {
                                    while($row = mysqli_fetch_array($result)) 
                                    {
                                        $selected = "";

                                        if ($row["category_id"] == $post_category) {
                                            $selected = "selected";
                                        }
                                        else {
                                            $selected = "";
                                        }

                                        echo "<option value='{$row['category_id']}' $selected>{$row['category_name']}</option>";
                                    }
                                }   
                            }            
                        ?>
                    </select>
                    <?php echo $post_category_error ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">Post Image: </label>
                <div class="col-md-9">
                    <input name="post_img" type="file" class="form-control"  accept="image/*">
                    <?php
                        if (empty($post_img_error) && isset($_POST["add_post"])) {
                            echo '<img src="uploads/'.htmlspecialchars($post_img).'"  alt="Post_Image" class="img-fluid mt-3">';
                        }
                        else {
                            echo $post_img_error;
                        }
                    ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">Post Description: </label>
                <div class="col-md-9">
                    <textarea name="post_description" class="form-control" rows="10" placeholder="Enter Post Description" required><?php echo $post_description ?></textarea>
                    <?php echo $post_description_error ?>
                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" name="add_post" class="btn btn-lg btn-primary font-weight-bolder">ADD POST RECORD</button>
            </div>

        </form>
    </div>
</div>

<?php
    include_once "footer.php";

    echo "<script>";
    
    if (isset($_POST['add_post'])) {

        if (empty($post_title_error) && empty($post_category_error) && empty($post_img_error) && empty($post_description_error)) {

            $post_author = $_SESSION["user"]["user_id"];
            $post_date = date("d M, Y");

            $sql = "INSERT INTO post (post_title, post_img, post_description, post_category, post_author, post_date) VALUES ('{$post_title}', '{$post_img}', '{$post_description}', '{$post_category}', '{$post_author}', '{$post_date}');";

        $sql .= "UPDATE category SET no_of_post = no_of_post + 1 WHERE category_id = {$post_category};";
        
            if (mysqli_multi_query($connection, $sql)) 
            {
                echo "location.href='post.php'";
            }
            else {
                echo "alert('Query Unsuccessfull');";
            }
        }
        else {
            echo "showMessage('#message', 'danger', 'Error!', 'Some Error Occured. Please Try Again!');"; 
        }
    }

    echo "</script>";
?>