<?php       
    include_once "header.php";

    if ($_SESSION["user"]["user_role"] == "subscriber") {
        header("Location: post.php");
    }
?>

<div class="my-5 pb-3 container-lg container-fluid">
    <h3 class="text-center">UPDATE USERS RECORDS</h3>
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

        $user_id = $first_name = $last_name = $username = $user_role = ""; 
        $first_name_error = $last_name_error = $username_error = $user_role_error = ""; 

        if ((isset($_POST['update_user']))) {

            $user_id = $_POST["user_id"];

            if (empty($_POST["first_name"])) {
                $first_name = "<b class='text-danger'>* This Field is Required</b>";
            }
            else {
                $first_name = convert_input($_POST["first_name"]);
                
                if (!preg_match("/^[a-zA-Z0-9]{3,30}$/", $first_name)) {
                    $first_name_error = "<b class='text-danger'>First Name Contains At Least 3 characters and at most 30 characters Allowed. No Special Character is Allowed</b>";
                }
            }

            if (empty($_POST["last_name"])) {
                $last_name = "<b class='text-danger'>* This Field is Required</b>";
            }
            else {
                $last_name = convert_input($_POST["last_name"]);
                
                if (!preg_match("/^[a-zA-Z0-9]{3,30}$/", $last_name)) {
                    $last_name_error = "<b class='text-danger'>Last Name Contains At Least 3 characters and at most 30 characters Allowed. No Special Character is Allowed</b>";
                }
            }

            if (empty($_POST["username"])) {
                $username = "<b class='text-danger'>* This Field is Required</b>";
            }
            else {
                $username = convert_input($_POST["username"]);
                
                if (!preg_match("/^[a-zA-Z0-9]{3,30}$/", $username)) {
                    $username_error = "<b class='text-danger'>Username Contains At Least 3 characters and at most 30 characters Allowed. No Special Character is Allowed</b>";
                }
                else {
                    $sql = "SELECT username FROM users WHERE user_id = '$user_id'";
                    
                    if ($result = mysqli_query($connection, $sql))
                    {
                        if (mysqli_num_rows($result) > 0) 
                        {
                            $row = mysqli_fetch_array($result);

                            $current_username = $row["username"];

                            $sql = "SELECT username FROM users";
                            $db_user_arr = []; 
                    
                            if ($result = mysqli_query($connection, $sql))
                            {
                                if (mysqli_num_rows($result) > 0) 
                                {
                                    while ($row = mysqli_fetch_array($result)) {
                                        array_push($db_user_arr, $row["username"]);
                                    }
                                }
                            }
                            else {
                                echo "<script>alert('Query Unsuccessfull')</script>";
                            }

                            array_splice($db_user_arr, array_search($current_username, $db_user_arr), 1);

                            if (in_array($username, $db_user_arr)) {
                                $username_error = "<b class='text-danger'> Username is already registered. Please Try Different Username.</b>";  
                            }
                        }   
                    } 
                    else {
                        echo "<script>alert('Query Unsuccessfull')</script>";
                    }
                }
            }

            if (empty($_POST["user_role"])) {
                $user_role_error = "<b class='text-danger'>* This Field is Required</b>";
            }
            else {
                $user_role = convert_input($_POST["user_role"]);
            }
        }

        $row = [];

        if (isset($_GET['user_id'])) {

            $sql = "SELECT user_id, username, first_name, last_name, user_role FROM users WHERE user_id = '{$_GET['user_id']}'";

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

            <input type="hidden" name="user_id" value="<?php echo isset($_GET["user_id"])? $_GET["user_id"] : $user_id ?>">

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">First Name: </label>
                <div class="col-md-9">
                    <input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?php echo isset($row["first_name"])? $row["first_name"] : $first_name ?>" required>
                    <?php echo $first_name_error ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">Last Name: </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="<?php echo isset($row["last_name"])? $row["last_name"] : $last_name ?>" required>
                    <?php echo $last_name_error ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">Username: </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo isset($row["username"])? $row["username"] : $username ?>" required>
                    <?php echo $username_error ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">User Role: </label>
                <div class="col-md-9">
                    <select name="user_role" class="form-select" required>
                        <option value="">Select User Role</option>

                        <option value='admin' 
                        <?php
                            echo ((isset($row["user_role"]) ? $row["user_role"] : $user_role) == "admin") ? "selected" : "";
                        ?> 
                        >Admin</option>

                        <option value='subscriber' 
                        <?php
                            echo ((isset($row["user_role"]) ? $row["user_role"] : $user_role) == "subscriber") ? "selected" : "";
                        ?> 
                        >Subscriber</option>
                    </select>
                    <?php echo $user_role_error ?>
                </div>
            </div>

            
            <div class="mt-4 text-center">
                <button type="submit" name="update_user" class="btn btn-lg btn-primary font-weight-bolder">UPDATE USER RECORD</button>
            </div>
            
        </form>
    </div>
</div>

<?php 
    include_once "footer.php";

    echo "<script>";

    if (isset($_POST['update_user'])) {

        if (empty($first_name_error) && empty($last_name_error) && empty($username_error) && empty($user_role_error)) {

            $sql = "UPDATE users SET first_name = '{$first_name}', last_name = '{$last_name}', username = '{$username}', user_role = '{$user_role}' WHERE user_id = '{$user_id}';";
            
            mysqli_query($connection, $sql) or die("Query Unsuccessfull");

            echo "<script>location.href = 'users.php';</script>";
        }
    }

    echo "</script>";
?>