<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Registration System - Signup Page</title>

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

        $name = $email = $phone = $password1 = $password2 = "";
        $nameError = $emailError = $phoneError = $password1Error = $password2Error = "";

        if ((isset($_POST['signupBtn']))) {

            if (empty($_POST["name"])) {
                $nameError = "<b class='text-danger'>* Name is Required</b>";
            }
            else {
                $name = convert_input($_POST["name"]);
                
                if (!preg_match("/^[a-zA-Z ]{3,30}$/", $name)) {
                    $nameError = "<b class='text-danger'>Name Contains at most 30 characters Allowed. No Special & Numeric Chracters is Allowed</b>";
                }
            }

            if (empty($_POST["email"])) {
                $emailError = "<b class='text-danger'>* Email is Required</b>";
            }
            else {
                $email = convert_input($_POST["email"]);
                
                if (!preg_match('/^((([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,})))|(^[0-9]{11}$)$/', $email)) {
                    $emailError = "<b class='text-danger'>Invalid Email Format. Please Enter Again</b>";
                }
                else {
                    $sql = "SELECT email FROM signup WHERE email = '$email'";
                    
                    if ($result = mysqli_query($connection, $sql)) 
                    {
                        if(mysqli_num_rows($result) > 0) 
                        {
                            $emailError = "<b class='text-danger'> Email is already registered. Please Try Different Email.</b>";  
                        }   
                    } 
                }
            }

            if (empty($_POST["phone"])) {
                $phoneError = "<b class='text-danger'>* Phone Number is Required</b>";
            }
            else {
                $phone = convert_input($_POST["phone"]);
                
                if (!preg_match("/^[0-9]{11}$/", $phone)) {
                    $phoneError = "<b class='text-danger'> Phone Number must Contains 11 characters Allowed.</b>";
                }
                else {

                    $sql = "SELECT phone FROM signup WHERE phone = '$phone'";
                    
                    if ($result = mysqli_query($connection, $sql)) 
                    {
                        if(mysqli_num_rows($result) > 0) 
                        {
                            $phoneError = "<b class='text-danger'> Phone Number is already registered. Please Try Different Number.</b>";
                        }   
                    }    
                }
            }

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
                $password2Error = "<b class='text-danger'>* Password is Required</b>";
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
            <h4 class="card-title mt-3 text-center">Create Account</h4>
            <p class="text-center">Get started with your free account</p>
            <p>
                <a href="" class="btn btn-block btn-twitter"> <i class="fab fa-twitter"></i>   Login via Twitter</a>
                <a href="" class="btn btn-block btn-facebook"> <i class="fab fa-facebook-f"></i>   Login via
                    facebook</a>
            </p>
            <p class="divider-text">
                <span class="bg-light">OR</span>
            </p>
            <div id="message"></div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <span><?php echo $nameError ?></span>
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                    </div>
                    <input name="name" class="form-control" placeholder="Full name" type="text" required
                        value="<?php echo $name ?>">
                </div> <!-- form-group// -->
                <span><?php echo $emailError ?></span>
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                    </div>
                    <input name="email" class="form-control" placeholder="Email address" type="email" required
                        value="<?php echo $email ?>">
                </div> <!-- form-group// -->
                <span><?php echo $phoneError ?></span>
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                    </div>
                    <input name="phone" class="form-control" placeholder="Phone number" type="number" required
                        value="<?php echo $phone ?>">
                </div>
                <span><?php echo $password1Error ?></span>
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                    </div>
                    <input name="password1" class="form-control" placeholder="Create password" type="password" required>
                </div> <!-- form-group// -->
                <span><?php echo $password2Error ?></span>
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                    </div>
                    <input name="password2" class="form-control" placeholder="Repeat password" type="password" required>
                </div> <!-- form-group// -->
                <div class="form-group">
                    <button type="submit" name="signupBtn" class="btn btn-primary btn-block"> Create Account </button>
                </div> <!-- form-group// -->
                <p class="text-center">Have an account? <a href="login.php">Log In</a> </p>
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

            if (empty($nameError) && empty($emailError) && empty($phoneError) && empty($password1Error) && empty($password2Error)) {

                $token = bin2hex(random_bytes(15));

                $sql = "INSERT INTO signup (name, email, phone, password, token, validity) VALUES ('{$name}', '{$email}', '{$phone}', '{$password1}', '{$token}', 'invalid');";
            
               if (mysqli_query($connection, $sql)) {
                   $to = $email;
                   $subject = "Verify Your Email Account";
                   $senderName = "WEB DEV";
                   $senderEmail = "90tricks90@gmail.com";
                   $verificationLink = "http://localhost/user-registration/activate.php?token=$token";
                   $message = "";

                   include "mail.php";

                   mail_message($message, $name, $verificationLink);

                   if (send_mail($to, $subject, $message, $senderName, $senderEmail)) {
                        $_SESSION["message"] = "Check Your Mail to Verify Your Account! $email";
                        echo "showMessage('#message', 'warning', 'Congratulations!', 'Your Account is Created Successfully.{$_SESSION["message"]}');location.href = 'login.php'";  
                   }
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