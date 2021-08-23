<?php
    include_once "header.php";

    if (isset($_SESSION["user"])) {
        header("Location: post.php");
    }
?>

<style>
    body *{
        font-family: "Verdana", serif;
    }
    .bg-full {
        width: 100%;
        min-height: 100vh;
    }

    .card {
        align-items: center
    }

    .card-title {
        font-weight: bolder;
        font-size: 25px;
    }

    .bg-dark {
        background-color: #212121 !important;
    }

    .fa-lock {
        color: #212121; 
    }

    .card-body {
        width: 600px;
        min-height: 350px;
        border-radius: 20px;
        box-shadow: -5px 5px 50px rgba(0, 0, 0, 0.3), 5px -5px 50px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: center;
        flex-direction: column;
        flex: 0 0 auto;
        margin: auto 20px;
    }

    input {
        font-size: 20px !important;
        padding: 10px !important;
    }

    input::placeholder {
        font-size: 20px !important;
    }

    .forgot-link {
        font-weight: bolder;
        padding-bottom: 15px;
        display: block;
        font-size: 18px !important;
    }

    button {
        text-transform: uppercase;
        padding: 10px 0 !important;
        font-weight: bolder;
        font-size: 18px !important; 
        margin-bottom: 30px;
    }

    @media all and (max-width: 600px) {
        .card-body {
            width: unset;
            max-width: 600px;
        }
    }
</style>

<?php 
    function convert_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = mysqli_real_escape_string($GLOBALS["connection"], $data);
        return $data;
    }

    $username_email = $password = "" ;
    $username_email_error = $password_error = "";
    
    if (isset($_POST['login'])) 
    {
        if (empty($_POST["username_email"])) 
        {
            $username_email = "<b class='text-danger align-self-start'>* This Field is Required</b>";
        }
        else 
        {
            $username_email = convert_input($_POST["username_email"]);
            
            $sql = "SELECT user_id FROM users WHERE status = 'verified' AND (email = '$username_email' OR username = '$username_email')";
            
            if ($result = mysqli_query($connection, $sql))
            {
                if(!mysqli_num_rows($result)) 
                {
                    $username_email_error = "<b class='text-danger align-self-start'> Username/Email is Not Valid. Please Enter Valid Details.</b>";  
                } 
            }
            else {
                echo "<script>alert('Query Unsuccessfull')</script>";
            }
        }

        if (empty($_POST["password"])) {
            $password_error = "<b class='text-danger align-self-start'>* This Field is Required</b>";
        }
        else {
            $password = convert_input($_POST["password"]);
            
            if (empty($username_email_error)) {
                $sql = "SELECT password FROM users WHERE status = 'verified' AND (email = '$username_email' OR username = '$username_email')";
            
                if ($result = mysqli_query($connection, $sql)) 
                {
                    if(mysqli_num_rows($result) > 0)
                    {
                        $row = mysqli_fetch_array($result);
                            
                        if (!password_verify($password, $row["password"])) {
                            $password_error = "<b class='text-danger align-self-start'>Incorrect Username/Email and Password. Please Enter Correct Details.</b>";
                        }
                    }
                    else {
                        $password_error = "<b class='text-danger align-self-start'>Incorrect Username/Email and Password. Please Enter Correct Details.</b>"; 
                    }
                }
                else {
                    echo "<script>alert('Query Unsuccessfull')</script>"; 
                }
            }
        }
    }
?>

<div class="card bg-dark bg-full">
    <article class="card-body bg-light my-auto">
        
        <h4 class="card-title mt-4 text-center">Login Your Account</h4>
        <p class="text-center mb-4">Login Your Account With Username / Email and Password</p>
        
        <div id="message"></div>

        <form method="post" class='mx-4' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">

            <span><?php echo $username_email_error ?></span>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                <input name="username_email" class="form-control" placeholder="Enter Username/Email" type="text" required>
            </div><!-- form-group// -->

            <span><?php echo $password_error ?></span>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                <input name="password" class="form-control" placeholder="Enter Password" type="password" required>
            </div><!-- form-group// -->

            <a class="forgot-link" href="forgot-password.php">Forget Password?</a>
            
            <div class="form-group">
                <button type="submit" name="login" class="btn bg-dark text-white btn-block"> LOGIN ACCOUNT </button>
            </div> <!-- form-group// -->
        </form>
    </article>
</div>

<?php 
    include_once "footer.php";

    echo "<script>";

    if (isset($_SESSION["account_verification_msg"])) {
        if ($_SESSION["account_verification_msg"]["status"] == "danger") {
            echo "showMessage('#message', 'danger', 'Error!', '{$_SESSION["account_verification_msg"]["msg"]}');";
        }
        else if ($_SESSION["account_verification_msg"]["status"] == "success") {
            echo "showMessage('#message', 'warning', 'Congratulations!', '{$_SESSION["account_verification_msg"]["msg"]}');";
        }
    }

    if (isset($_SESSION["reset_password_message"])) {
        if ($_SESSION["reset_password_message"]["status"] == "danger") {
            echo "showMessage('#message', 'danger', 'Please!', '{$_SESSION["reset_password_message"]["msg"]}');";
        }
        else if ($_SESSION["reset_password_message"]["status"] == "success") {
            echo "showMessage('#message', 'warning', 'Congratulations!', '{$_SESSION["reset_password_message"]["msg"]}');";
        }

    }

    if (isset($_POST["login"])) {

        if (empty($username_email_error) && empty($password_error)) {

            if (isset($_SESSION['account_verification_msg'])) {
                unset($_SESSION['account_verification_msg']);
            }

            
            if (isset($_SESSION['reset_password_message'])) {
                unset($_SESSION['reset_password_message']);
            }

            $sql = "SELECT username, user_role, user_id FROM users WHERE email = '$username_email' OR username = '$username_email'";
                
            if ($result = mysqli_query($connection, $sql)) 
            {
                if(mysqli_num_rows($result) > 0)
                {
                    while ($row = mysqli_fetch_array($result)) {        
                        $_SESSION["user"] = [
                            "username" => $row["username"],
                            "user_role" => $row["user_role"],
                            "user_id" => $row["user_id"],
                        ];
                    }

                    echo "location.href='post.php'";
                }
            } 
            else {
                echo "alert('Query Unsuccessfull');";
            }
        }
        else {
            echo "showMessage('#message', 'danger', 'Error!', 'Something Went Wrong! Please Try Again.');";
        }         
    }

    echo "</script>";
?>