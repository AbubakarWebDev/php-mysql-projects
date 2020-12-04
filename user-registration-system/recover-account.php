<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Panel - Recover Account</title>

    <?php include "links.php" ?>
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

        $email = $email_error = "";

        if ((isset($_POST['find_btn']))) {

            if (empty($_POST["email"])) {
                $email_error = "<b class='text-danger'>* Email is Required</b>";
            }
            else {
                $email = convert_input($_POST["email"]);
                
                if (!preg_match('/^((([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,})))|(^[0-9]{11}$)$/', $email)) {
                    $email_error = "<b class='text-danger'>Invalid Email Format. Please Enter Again</b>";
                }
                else {
                    $sql = "SELECT email FROM users WHERE email = '$email' AND status = 'verified'";
                    
                    if ($result = mysqli_query($connection, $sql)) 
                    {
                        if(!(mysqli_num_rows($result) > 0))
                        {
                            $email_error = "<b class='text-danger'>Incorrect Email. Please Enter Correct Email.</b>";  
                        }
                    } 
                    else {
                        echo "<script>alert('Query Unsuccessfull')</script>";
                    }
                }
            }
        }
    ?>

    <div class="card bg-light bg-full">
        <article class="card-body mx-auto">
            <h4 class="card-title mt-3 text-center">Find Your Account</h4>
            <p class="text-center">Please enter your email address to search for your account.</p>
            <div id="message"></div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <span><?php echo $email_error ?></span>
                <div class="form-group input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                    </div>
                    <input name="email" class="form-control" placeholder="Email address" type="email" required value="<?php echo $email ?>">
                </div> <!-- form-group// -->
                <div class="form-group">
                    <button type="submit" name="find_btn" class="btn btn-primary btn-block"> Find Account </button>
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
    }

    <?php 
    
    if (isset($_POST['find_btn'])) {

        if (empty($email_error)) {
            
            $sql = "SELECT name, token FROM signup WHERE email = '$email'";
            
            if ($result = mysqli_query($connection, $sql)) {

                $row = mysqli_fetch_array($result);
                $name = $row['name'];
                $token = $row['token'];

                
                $to = $email;
                $subject = "Password Reset Email";
                $senderName = "WEB DEV";
                $senderEmail = "90tricks90@gmail.com";
                $verificationLink = "http://localhost/user-registration/reset-password.php?token=$token";
                $message = "";
                
                include "mail.php";
                    
                recover_message($message, $name, $verificationLink);

                if (send_mail($to, $subject, $message, $senderName, $senderEmail)) {
                    $_SESSION["message"] = "Check Your Mail to Reset Your Account Password";
                    echo "showMessage('#message', 'warning', 'Please!', '{$_SESSION["message"]}');location.href = 'login.php'";  
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