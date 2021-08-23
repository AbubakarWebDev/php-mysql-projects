<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">

    <title>File Upload Form</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <h1 style="font-size: 1.5rem;">File Managment System</h1>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navBar" aria-controls="navBar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navBar">
                <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
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
        </div>
    </nav>

    <?php  
        session_start();
        
        if (isset($_SESSION["data"])) {
            $GLOBALS["filedata"] = $_SESSION["data"];
        }
    ?>

    <div class="container">
    <hr>
    <h1 class="text-center">PHP File Uploading & Downloading</h1>
    <hr>
    <h6 class="text-center"><strong>Note:</strong> Only jpg, jpeg, gif, png file formats allowed to a max size of 5 MB.</h6>
    <hr>
    <div id="message"></div>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3">
                    <h2>Upload File:</h2>
                </div>
                <div class="col-md-9">
                    <div class="form-file form-file-lg mb-2 mt-1">
                        <input type="file" name="photo[]" class="form-file-input" multiple id="file">
                        <label class="form-file-label" for="file">
                        <span class="form-file-text">No File Choosen! Please Choose file...</span>
                        <span class="form-file-button">Browse</span>
                    </div>
                    <?php echo isset($filedata["file_error_message"])? $filedata["file_error_message"] : "" ?>
                </div>
            </div>

            <div class="text-center mt-4">
                <input class="btn btn-primary btn-lg" type="submit" name="submit" value="Upload File">
            </div>
            
            <hr>
        </form>
        <div class="text-center">
        <?php
        
            $path = "uploads";

            // Check directory exists or not
            if(file_exists($path) && is_dir($path)){
                
                // Scan the files in this directory
                $result = scandir($path);
                
                // Filter out the current (.) and parent (..) directories
                $files = array_diff($result, array('.', '..'));
            
                if(count($files) > 0) {
                    // Loop through array to create image gallery
                    foreach($files as $file) 
                    {
                        echo '<div class="card m-3" style="width:18rem; display:inline-block;">';
                        echo '<img src="uploads/' .$file. '" class="card-img-top" alt="' .pathinfo($file, PATHINFO_FILENAME). '">';
                        echo '<div class="card-body">
                                <a href="download.php?file='.urlencode($file).'" class="btn btn-lg mb-2 btn-primary">Download Image</a>
                                <a href="delete.php?file='.urlencode($file).'" class="btn btn-lg btn-primary">Delete Image</a>
                            </div>
                        </div>';
                    }
                    echo '<hr class="mb-5">';
                } 
            } 
            else {
                echo "ERROR: The directory does not exist.";
            }
        ?>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>

    <script>
        let fileName = "";
        document.querySelector("#file").onchange = function () 
        {
            fileName = "";
            for (let i = 0; i < this.files.length; i++) {
                if (i == this.files.length - 1) {
                    fileName += "\"" + this.files[i].name + "\"";
                }
                else {
                    fileName += "\"" + this.files[i].name + "\"" + ", ";
                }
            }
            document.querySelector(".form-file-text").innerText = fileName;
        }

        function showMessage(selector, type, slogan, mymassage) {
            let massage = document.querySelector(selector);
            massage.innerHTML =
                `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    <strong>${slogan}</strong> ${mymassage}.
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                </div>`;

            setTimeout(function() {
                if (massage.innerHTML.indexOf('alert-warning') !== -1) {
                    massage.innerHTML = "";
                }
            }, 5000)
        }

        <?php
        
            if (isset($filedata["file_error_message"])) {
                if (empty($filedata["file_error_message"])) {
                    echo "showMessage('#message', 'warning', 'Congratulations!', 'Your File is Uploaded Successfully');";
                }
                else {
                    echo "showMessage('#message', 'danger', 'Error!', 'Some Error Occured. Please Try Again!');"; 
                }
            }

            // Removing session data
            if(isset($_SESSION["data"])) {
                unset($_SESSION["data"]);
            }

        ?>

    </script>
</body>

</html>