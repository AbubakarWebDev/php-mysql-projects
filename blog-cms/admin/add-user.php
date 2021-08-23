<?php     
    include_once "header.php";

    if ($_SESSION["user"]["user_role"] == "subscriber") {
        header("Location: post.php");
    }
?>

<div class="my-5 pb-3 container-lg container-fluid">
    <h3 class="text-center">ADD USERS RECORDS</h3>
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

        $first_name = $last_name = $username = $email = $password = $encrypted_password = $confirm_password = $user_role = ""; 
        $first_name_error = $last_name_error = $username_error = $email_error = $password_error = $confirm_password_error = $user_role_error = ""; 

        if ((isset($_POST['adduser']))) {

            if (empty($_POST["first_name"])) {
                $first_name_error = "<b class='text-danger'>* This Field is Required</b>";
            }
            else {
                $first_name = convert_input($_POST["first_name"]);
                
                if (!preg_match("/^[a-zA-Z0-9]{3,30}$/", $first_name)) {
                    $first_name_error = "<b class='text-danger'>First Name Contains At Least 3 characters and at most 30 characters Allowed. No Special Character is Allowed</b>";
                }
            }

            if (empty($_POST["last_name"])) {
                $last_name_error = "<b class='text-danger'>* This Field is Required</b>";
            }
            else {
                $last_name = convert_input($_POST["last_name"]);
                
                if (!preg_match("/^[a-zA-Z0-9]{3,30}$/", $last_name)) {
                    $last_name_error = "<b class='text-danger'>Last Name Contains At Least 3 characters and at most 30 characters Allowed. No Special Character is Allowed</b>";
                }
            }

            if (empty($_POST["username"])) {
                $username_error = "<b class='text-danger'>* This Field is Required</b>";
            }
            else {
                $username = convert_input($_POST["username"]);
                
                if (!preg_match("/^[a-zA-Z0-9]{3,30}$/", $username)) {
                    $username_error = "<b class='text-danger'>Username Contains At Least 3 characters and at most 30 characters Allowed. No Special Character is Allowed</b>";
                }
                else {
                    $sql = "SELECT username FROM users WHERE username = '$username'";
                    
                    if ($result = mysqli_query($connection, $sql)) 
                    {
                        if(mysqli_num_rows($result) > 0) 
                        {
                            $username_error = "<b class='text-danger'> Username is already registered. Please Try Different Username.</b>";  
                        }   
                    } 
                }
            }

            if (empty($_POST["user_role"])) {
                $user_role_error = "<b class='text-danger'>* This Field is Required</b>";
            }
            else {
                $user_role = convert_input($_POST["user_role"]);
            }

            if (empty($_POST["email"])) {
                $email_error = "<b class='text-danger'>* This Field  is Required</b>";
            }
            else {
                $email = convert_input($_POST["email"]);
                
                if (!preg_match('/^((([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,})))|(^[0-9]{11}$)$/', $email)) {
                    $email_error = "<b class='text-danger'>Invalid Email Format. Please Enter Again</b>";
                }
                else {
                    $sql = "SELECT email FROM users WHERE email = '$email'";
                    
                    if ($result = mysqli_query($connection, $sql)) 
                    {
                        if(mysqli_num_rows($result) > 0) 
                        {
                            $email_error = "<b class='text-danger'> Email is already registered. Please Try Different Email.</b>";  
                        }   
                    } 
                }
            }

            if (empty($_POST["password"])) {
                $password_error = "<b class='text-danger'>* This Field  is Required</b>";
            }
            else {
                $password = convert_input($_POST["password"]);
                
                if (strlen($password) < 8) {
                    $password_error = "<b class='text-danger'>Password Must Contains At Least 8 Characters</b>";
                }
            }
            
            if (empty($_POST["confirm_password"])) {
                $confirm_password_error = "<b class='text-danger'>* This Field  is Required</b>";
            }
            else {
                $confirm_password = convert_input($_POST["confirm_password"]);
                
                if ($password === $confirm_password) {
                    $encrypted_password = password_hash($password, PASSWORD_BCRYPT);
                }
                else {
                    $confirm_password_error = "<b class='text-danger'>Confirm Password is Not Matched</b>";
                }
            }
        }
    ?>

    <div class="form-container mt-5">
        <div id="message"></div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">First Name: </label>
                <div class="col-md-9">
                    <input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?php echo $first_name ?>" required>
                    <?php echo $first_name_error ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">Last Name: </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="<?php echo $last_name ?>" required>
                    <?php echo $last_name_error ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">Username: </label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $username ?>" required>
                    <?php echo $username_error ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">User Role: </label>
                <div class="col-md-9">
                    <select name="user_role" class="form-select" required>
                        <option value="">Select User Role</option>
                        <option value='admin' <?php echo ($user_role == "admin")? "selected" : "" ?> >Admin</option>
                        <option value='subscriber' <?php echo ($user_role == "subscriber")? "selected" : "" ?> >Subscriber</option>
                    </select>
                    <?php echo $user_role_error ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">Email: </label>
                <div class="col-md-9">
                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $email ?>" required>
                    <?php echo $email_error ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">Password: </label>
                <div class="col-md-9">
                    <input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo $password ?>" required>
                    <?php echo $password_error ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-3 col-form-label">Confirm Password: </label>
                <div class="col-md-9">
                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" value="<?php echo $confirm_password ?>" required>
                    <?php echo $confirm_password_error ?>
                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" name="adduser" class="btn btn-lg btn-primary font-weight-bolder">ADD USER RECORD</button>
            </div>

        </form>
    </div>
</div>

<?php include_once "footer.php"; ?>

<script>
    <?php
        if (isset($_POST['adduser'])) {

            if (empty($first_name_error) && empty($last_name_error) && empty($username_error) && empty($email_error) && empty($user_role_error) && empty($password_error) && empty($confirm_password_error)) {

                $token = bin2hex(random_bytes(15));

                $sql = "INSERT INTO users (first_name, last_name, username, email, user_role, password, token, status) VALUES ('{$first_name}', '{$last_name}', '{$username}', '{$email}', '{$user_role}', '{$encrypted_password}', '{$token}', 'notverified');";
            
                if (mysqli_query($connection, $sql)) {
                    $to = $email;
                    $subject = "Verify Your Email Account";
                    $senderName = "Tech Memorise";
                    $senderEmail = "90tricks90@gmail.com";
                    $verificationLink = "{$hostname}blog-cms/admin/activate.php?token=$token";
                    $message = "";

                    include_once "mail.php";

                    activation_message($message, "$first_name $last_name", $verificationLink);

                    if (send_mail($to, $subject, $message, $senderName, $senderEmail)) {
                        echo "showMessage('#message', 'warning', 'Congratulations!', 'User Account is Created Successfully. Verfication Email has been Sent to $email')";  
                    }
                    else {
                        echo "alert('Mail Unsuccessfull');";
                    }
                }
                else {
                    echo "alert('Query Unsuccessfull');";
                }
            }
            else {
                echo "showMessage('#message', 'danger', 'Error!', 'Some Error Occured. Please Try Again!');"; 
            }
        }
    ?>
</script>