<?php 
if (!isset($_GET['token'])) {
    header("Location: login.php");
}
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Registration System - Signup Page</title>

    <?php include "links.php"; ?>
</head>

<style>
    .bg-full {
        width: 100%;
        min-height: 100vh;
    }

    .card {
        align-items: center
    }

    .card-body {
        width: 500px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
</style>

<body>

    <?php

        include "config.php";

        function convert_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            $data = mysqli_real_escape_string($GLOBALS["connection"], $data);
            return $data;
        }

        $password1 = $password2 = $token = "";
        $password1Error = $password2Error = "";

        if ((isset($_POST['signupBtn']))) {

            $token = $_POST["token"];

            if (empty($_POST["password1"])) {
                $password1Error = "<b class='text-danger'>* Password is Required</b>";
            }
            else {
                $password1 = convert_input($_POST["password1"]);
                
                if (strlen($password1) < 8) {
                    $password1Error = "<b class='text-danger'>Password Must Contains At Least 8 Characters</b>";
                }
            }
            
            if (empty($_POST["password2"])) {
                $password2Error = "<b class='text-danger'>* New Password is Required</b>";
            }
            else {
                $password2 = convert_input($_POST["password2"]);
                
                if ($password1 === $password2) {
                    $password1 = password_hash($password1, PASSWORD_BCRYPT);
                    $password2 = password_hash($password2, PASSWORD_BCRYPT);
                }
                else {
                    $password2Error = "<b class='text-danger'>Confirm Password is Not Matched</b>";
                }
            }
        }
    ?>

    <div class="card bg-light bg-full">
        <article class="card-body">
            <h4 class="card-title mt-3 text-center">Reset Account Password</h4>
            <p class="text-center">Reset Your Account Password by Entering New Password</p>
            <div id="message"></div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <input type="hidden" name="token" value="<?php echo isset($_GET['token'])? $_GET["token"] : ""  ?>">
                <span><?php echo $password1Error ?></span>
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                    </div>
                    <input name="password1" class="form-control" placeholder="New password" type="password" required>
                </div> <!-- form-group// -->
                <span><?php echo $password2Error ?></span>
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                    </div>
                    <input name="password2" class="form-control" placeholder="Confirm password" type="password" required>
                </div> <!-- form-group// -->
                <div class="form-group">
                    <button type="submit" name="signupBtn" class="btn btn-primary btn-block"> Update Password </button>
                </div> <!-- form-group// -->
            </form>
        </article>
    </div>

    <?php include "scripts.php"; ?>

    <script>
    function showMessage(selector, type, slogan, mymassage) {
        let massage = document.querySelector(selector);
        massage.innerHTML =
            `<div id="alert-success" class="alert alert-${type} alert-dismissible fade show" role="alert">
                <strong>${slogan}</strong> ${mymassage}.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>`;

        setTimeout(function() {
            if (massage.innerHTML.indexOf('alert-warning') !== -1) {
                massage.innerHTML = "";
            }
        }, 5000)
    }

    <?php
        if (isset($_POST['signupBtn'])) {

            if (empty($password1Error) && empty($password2Error)) {
                $sql = "UPDATE signup SET password = '$password1' WHERE token = '$token'";
                
                if (mysqli_query($connection, $sql)) {
                    $_SESSION["message"] = "Your New Password Has Been Updated";
                    echo "showMessage('#message', 'warning', '', '{$_SESSION["message"]}');location.href = 'login.php'";
                }
            }
            else {
                echo "showMessage('#message', 'danger', 'Error!', 'Some Error Occured. Please Try Again!');"; 
            }
        }
    ?>
    </script>
</body>

</html>