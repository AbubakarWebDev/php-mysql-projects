<?php 
    session_start();
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Registration System - Login Page</title>

    <?php include "links.php"; ?>
</head>

<style>
    .divider-text {
        position: relative;
        text-align: center;
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .divider-text span {
        padding: 7px;
        font-size: 12px;
        position: relative;
        z-index: 2;
    }

    .divider-text:after {
        content: "";
        position: absolute;
        width: 100%;
        border-bottom: 1px solid #ddd;
        top: 55%;
        left: 0;
        z-index: 1;
    }

    .btn-facebook {
        background-color: #405D9D;
        color: #fff;
    }

    .btn-twitter {
        background-color: #42AEEC;
        color: #fff;
    }

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

        $email = $password = "";
        $emailError = $passwordError = "";

        if ((isset($_POST['loginBtn']))) {

            if (empty($_POST["email"])) {
                $emailError = "<b class='text-danger'>* Email is Required</b>";
            }
            else {
                $email = convert_input($_POST["email"]);
                
                if (!preg_match('/^((([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,})))|(^[0-9]{11}$)$/', $email)) {
                    $emailError = "<b class='text-danger'>Invalid Email Format. Please Enter Again</b>";
                }
                else {
                    $sql = "SELECT email FROM users WHERE email = '$email' AND validity = 'valid'";
                    
                    if ($result = mysqli_query($connection, $sql)) 
                    {
                        if(!(mysqli_num_rows($result) > 0))
                        {
                            $emailError = "<b class='text-danger'>Incorrect Email. Please Enter Correct Email.</b>";  
                        }
                    } 
                }
            }

            if (empty($_POST["password"])) {
                $passwordError = "<b class='text-danger'>* Password is Required</b>";
            }
            else {
                $password = convert_input($_POST["password"]);
                
                if (strlen($password) < 8) {
                    $passwordError = "<b class='text-danger'>Password Must Contains At Least 8 Characters</b>";
                }
                else if (empty($emailError)) {
                    $sql = "SELECT password FROM users WHERE email = '$email' AND validity = 'valid'";
                    
                    if ($result = mysqli_query($connection, $sql)) 
                    {
                        if(mysqli_num_rows($result) > 0) 
                        {
                            while ($row = mysqli_fetch_array($result)) {        
                                if (!password_verify($password, $row["password"])) {
                                    $passwordError = "<b class='text-danger'>Incorrect Password. Please Enter Correct Password.</b>";
                                }
                            }
                        }
                    } 
                }
            }
        }
    ?>

    <div class="card bg-light bg-full">
        <article class="card-body mx-auto">
            <h4 class="card-title mt-3 text-center">Login Your Account</h4>
            <p class="text-center">Login Your Account and Access Our Resources</p>
            <!-- <p>
                <a href="" class="btn btn-block btn-twitter"> <i class="fab fa-twitter"></i>   Login via Twitter</a>
                <a href="" class="btn btn-block btn-facebook"> <i class="fab fa-facebook-f"></i>   Login via facebook</a>
            </p>
            <p class="divider-text">
                <span class="bg-light">OR</span>
            </p> -->
            <div id="message"></div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <span><?php echo $emailError ?></span>
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                    </div>
                    <input name="email" class="form-control" placeholder="Email address" type="email" required value="<?php echo (isset($_COOKIE["emailCookie"]))? $_COOKIE["emailCookie"] : $email ?>">
                </div> <!-- form-group// -->
                <span><?php echo $passwordError ?></span>
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                    </div>
                    <input name="password" class="form-control" placeholder="Create password" type="password" value="<?php echo (isset($_COOKIE["passwordCookie"]))? $_COOKIE["passwordCookie"] : $password ?>" required>
                </div> <!-- form-group// -->
                <div class="custom-control custom-checkbox form-group">
                    <input type="checkbox" name="rememberme" class="custom-control-input" id="chkbox">
                    <label class="custom-control-label" for="chkbox">Remember Me</label>
                </div> <!-- form-group// -->
                <div class="form-group">
                    <button type="submit" name="loginBtn" class="btn btn-primary btn-block"> Login Account </button>
                </div> <!-- form-group// -->
                <div class="form-group">
                    <a href="recover-account.php"><button type="button" name="forgotBtn" class="btn btn-secondary btn-block"> Forgot Password </button></a>
                </div> <!-- form-group// -->
                <p class="text-center">Create an account? <a href="signup.php">Sign up</a> </p>
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
    }

    <?php
        if (isset($_POST['loginBtn'])) {

            if (empty($emailError) && empty($passwordError)) {

                $sql = "SELECT name FROM users WHERE email = '$email'";
                    
                if ($result = mysqli_query($connection, $sql)) 
                {
                    if(mysqli_num_rows($result) > 0) 
                    {
                        while ($row = mysqli_fetch_array($result)) {        
                            $_SESSION["username"] = $row["name"];
                        }
                    }
                } 

                if (isset($_POST['rememberme'])) {
                    setcookie("emailCookie", $email, time() + 86400);
                    setcookie("passwordCookie", $password, time() + 86400);
                }

                if (isset($_SESSION['message'])) {
                    unset($_SESSION['message']);
                }

                echo "showMessage('#message', 'warning', 'Congratulations!', 'Your Account is Logged In Successfully');location.href = 'index.php';";
            }
            else {
                echo "showMessage('#message', 'danger', 'Error!', 'Some Error Occured. Please Try Again!');"; 
            }
        }

        if (isset($_SESSION["message"])) {
            echo "showMessage('#message', 'warning', '', '{$_SESSION['message']}');";
        }

    ?>
    </script>
</body>

</html>