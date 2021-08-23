<?php include_once "header.php"; ?>

<style>
    .bg-full {
        width: 100%;
        min-height: 100vh;
    }

    .bg-dark {
        background-color: #212121 !important;
    }

    .fa-envelope {
        color: #212121; 
    }

    .card {
        align-items: center
    }
    
    .card-body {
        width: 600px;
        min-height: 300px;
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

<div class="card bg-dark bg-full">
    <article class="card-body my-auto bg-light">
        <h4 class="card-title text-center">Find Your Account</h4>
        <p class="text-center">Please enter your email address to search for your account.</p>
        
        <div id="message"></div>
        <form method="post" class="mx-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <span><?php echo $email_error ?></span>
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                <input name="email" class="form-control" placeholder="Email address" type="email" required value="<?php echo $email ?>">
            </div><!-- form-group// -->
            <div class="input-group">
                <button type="submit" name="find_btn" class="btn bg-dark text-white btn-block"> Find Account </button>
            </div> <!-- form-group// -->
        </form>
    </article>
</div>

<?php 
    include_once "footer.php";

    echo "<script>";
    
    if (isset($_POST['find_btn'])) {

        if (empty($email_error)) {
            
            $sql = "SELECT first_name, last_name, token FROM users WHERE email = '$email' AND status = 'verified'";
            
            if ($result = mysqli_query($connection, $sql)) {

                $row = mysqli_fetch_array($result);
                $name = "{$row['first_name']} {$row['last_name']}";
                $token = $row['token'];

                
                $to = $email;
                $subject = "Password Reset Email";
                $senderName = "Techmemorise";
                $senderEmail = "90tricks90@gmail.";
                $verificationLink = "{$hostname}blog-cms/admin/reset-password.php?token=$token";
                $message = "";
                
                include_once "mail.php";
                    
                recover_message($message, $name, $verificationLink);

                if (send_mail($to, $subject, $message, $senderName, $senderEmail)) {
                    $_SESSION["reset_password_message"] = [
                        "status" => "success",
                        "msg" => "Check Your Mail to Reset Your Account Password!"
                    ];
                    echo "showMessage('#message', 'warning', 'Please!', '{$_SESSION["reset_password_message"]["msg"]}');location.href = 'index.php'";
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

    echo "</script>";  
?>