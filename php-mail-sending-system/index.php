<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">

    <title>PHP Mailing System</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">

        <a class="navbar-brand ml-3" href="">
            <h1 style="font-size: 1.5rem;">PHP Mailing System</h1>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navBar" aria-controls="navBar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navBar">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0 mr-lg-3">
                <li class="nav-item">
                    <a class="nav-link" href="">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://abubakarwebdev.github.io/webapplications/#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://abubakarwebdev.github.io/webapplications/#contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://abubakarwebdev.github.io/webapplications/#privacypolicy">Privacy Policy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://abubakarwebdev.github.io/webapplications/#disclaimer">Disclaimer</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
    <hr>
    <h1 class="text-center">PHP Complete Mail Handling</h1>
    <hr>

    <?php 
        session_start();
        $emailMessage = [];

        if (isset($_SESSION["ALL_DATA"])) {
            $emailMessage = $_SESSION["ALL_DATA"];
        }

        function in_array_all($find,$array){        
            foreach($array as $key => $value){
                if($value != $find){
                    return false;
                }
            }
            return true;
        }

        if(!empty($emailMessage)) {
            if ((in_array_all("" , $emailMessage["dataError"])) && ($emailMessage["email"] == "OK")) {
                echo "<div id='message' class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Congratulations:</strong> Your Email was Send successfully.
                <button type='button' class='btn-close' data-dismiss='alert' aria-label='Close'></button>
                </div><script>setTimeout(() => {document.querySelector('#message').remove();}, 3000);</script>";
            }
            else {
                echo "<div class='alert alert-dark alert-dismissible fade show' role='alert'>
                <strong>Error:</strong> Your Email was Not Send successfully.
                <button type='button' class='btn-close' data-dismiss='alert' aria-label='Close'></button></div>";
            }
        }
    ?>
    
    <form action="sending-mail.php" method="POST" enctype="multipart/form-data">
        <div class="row mb-3">
            <div class="col-md-3">
                <h4>Receipient Email:</h4>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="receipientEmail" Placeholder="Enter Receipient Email" value="<?php if(!empty($emailMessage)) { echo $emailMessage["data"]["receipientEmail"]; } ?>">
                <?php if(!empty($emailMessage)) { echo $emailMessage["dataError"]["receipientEmailError"];} ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <h4>Sender Name:</h4>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="senderName" Placeholder="Enter Sender Name" value="<?php if(!empty($emailMessage)) { echo $emailMessage["data"]["senderName"]; } ?>">
                <?php if(!empty($emailMessage)) {  echo $emailMessage["dataError"]["senderNameError"]; } ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <h4>Sender Email:</h4>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="senderEmail" Placeholder="Enter Sender Email" value="<?php if(!empty($emailMessage)) { echo $emailMessage["data"]["senderEmail"]; }?>">
                <?php if(!empty($emailMessage)) { echo $emailMessage["dataError"]["senderEmailError"]; } ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <h4>Email Subject:</h4>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="emailSubject" Placeholder="Enter Email Subject" value="<?php if(!empty($emailMessage)) { echo $emailMessage["data"]["emailSubject"]; }?>">
                <?php if(!empty($emailMessage)) { echo $emailMessage["dataError"]["emailSubjectError"]; } ?>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <h4>Email Message:</h4>
            </div>
            <div class="col-md-9">
            <textarea class="form-control" name="emailBody" rows="8" placeholder="Enter Email Message"><?php if(!empty($emailMessage)) { echo $emailMessage["data"]["emailBody"]; } ?></textarea>
            <?php if(!empty($emailMessage)) { echo $emailMessage["dataError"]["emailBodyError"]; } ?>
            </div>
        </div>

        <hr><h6 class="text-center"><strong>Note:</strong> Only .jpg, .jpeg, .gif, .png, .doc, .xls, .ppt, .pdf, .txt,  file formats allowed to a max size of 10 MB.</h6><hr>

        <div class="row mb-3">
            <div class="col-md-3">
                <h4>Upload File:</h4>
            </div>
            <div class="col-md-9">
                <div class="form-file form-file mb-2 mt-1">
                    <input type="file" name="files[]" multiple class="form-file-input" id="file">
                    <label class="form-file-label" for="file">
                    <span class="form-file-text">No File Choosen! Please Choose file...</span>
                    <span class="form-file-button">Browse</span>
                </div>
                <?php if(!empty($emailMessage)) { echo $emailMessage["dataError"]["filesError"]; } ?>
            </div>
        </div>

        <div class="text-center mt-4">
            <input class="btn btn-primary btn-lg" type="submit" name="submit" value="Send Your Mail">
        </div>

        <hr>
    </form>

    <?php
        // Removing session data
        if(isset($_SESSION["ALL_DATA"])) {
            unset($_SESSION["ALL_DATA"]);
        }
        session_destroy();
    ?>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelector("#file").onchange = function(){
            let fileName = "";

            if (this.files.length > 1) {
                for (let i = 0; i < this.files.length; i++) {
                    fileName += this.files[i].name + ", ";
                }  
            }
            else if (this.files.length = 1) {
                fileName = this.files[0].name;
            }

            document.querySelector(".form-file-text").innerText = fileName;
        }
    </script>
</body>

</html>