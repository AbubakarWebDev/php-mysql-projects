<?php 
    if (!isset($_GET['token'])) {
        header("Location: index.php");
    }
    
    include_once "header.php";
?>

<style>
    .bg-full {
        width: 100%;
        min-height: 100vh;
    }

    .card {
        align-items: center
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

    $password = $confirm_password = $token = "";
    $password_error = $confirm_password_error = "";

    if ((isset($_POST['update_password']))) {

        $token = $_POST["token"];

        if (empty($_POST["password"])) {
            $password_error = "<b class='text-danger'>* Password is Required</b>";
        }
        else {
            $password = convert_input($_POST["password"]);
            
            if (strlen($password) < 8) {
                $password_error = "<b class='text-danger'>Password Must Contains At Least 8 Characters</b>";
            }
        }
        
        if (empty($_POST["confirm_password"])) {
            $confirm_password_error = "<b class='text-danger'>* New Password is Required</b>";
        }
        else {
            $confirm_password = convert_input($_POST["confirm_password"]);
            
            if ($password === $confirm_password) {   
                $password = password_hash($password, PASSWORD_BCRYPT);
            }
            else {
                $confirm_password_error = "<b class='text-danger'>Confirm Password is Not Matched</b>";
            }
        }
    }
?>

<div class="card bg-dark bg-full">
    <article class="card-body bg-light my-auto">
        <h4 class="card-title text-center">Reset Account Password</h4>
        <p class="text-center">Reset Your Account Password by Entering New Password</p>
        <div id="message"></div>
        <form method="post" class='mx-4' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <input type="hidden" name="token" value="<?php echo isset($_GET['token'])? $_GET["token"] : ""  ?>">

            <span><?php echo $password_error ?></span>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                <input name="password" class="form-control" placeholder="New password" type="password" required>
            </div><!-- form-group// -->

            <span><?php echo $confirm_password_error ?></span>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                <input name="confirm_password" class="form-control" placeholder="Confirm password" type="password" required>
            </div><!-- form-group// -->
            
            <div class="form-group">
                <button type="submit" name="update_password" class="btn bg-dark text-white btn-block"> Update Password </button>
            </div> <!-- form-group// -->
        </form>
    </article>
</div>

<?php
    include_once "footer.php";

    echo "<script>";

    if (isset($_POST['update_password'])) {

        if (empty($password_error) && empty($confirm_password_error)) {

            $sql = "UPDATE users SET password = '$password' WHERE token = '$token'";
            
            if (mysqli_query($connection, $sql)) {
                $_SESSION["reset_password_message"] = [
                    "status" => "success",
                    "msg" => "Your New Password Has Been Updated. Please Login Your Account!"
                ];
                echo "showMessage('#message', 'warning', 'Congratulation! ', '{$_SESSION["reset_password_message"]["msg"]}');location.href = 'index.php'";
            }
        }
        else {
            echo "showMessage('#message', 'danger', 'Error!', 'Some Error Occured. Please Try Again!');"; 
        }
    }

    echo "</script>";
?>