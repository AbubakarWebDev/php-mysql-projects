<!doctype html>
<html lang="en">

<head>
    <title>PHP CRUD | UPDATE RECORD</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
</head>
<style>
    .form-container {
        width: 80%;
        margin: 0 auto;
        padding: 50px 50px 30px 50px;
        background-color: #F2F2F2;
        border-radius: 10px;
        box-shadow: 0 0 0 18px rgba(0,0,0,0.5), 0 0 18px 0 rgba(0,0,0,0.5);
    }

    .form-container label {
        font-weight: bolder;
        font-size:20px;
    }
</style>
<body>

    <?php require "header.php"; ?>

    <div class="container-lg container-fluid">
        <hr>
        <h1 class="text-center">PHP CRUD APPLICATION <span class="badge bg-secondary">BY BKR</span></h1>
        <hr>
        <h3 class="text-center">DELETE STUDENTS RECORDS</h3>
        <center>
            <hr class="m-0" style="width:15%">
        </center>

        <?php 

            include "config.php";

            function convert_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                $data = mysqli_real_escape_string($GLOBALS["connection"], $data);
                return $data;
            }

            $id = $idError = "";

            if (isset($_POST['deleteBtn'])) {
                if (empty($_POST["id"])) {
                    $idError = "<b class='text-danger'>* ID is Required</b>";
                }
                else {
                    $id = convert_input($_POST["id"]);
                    
                    if (!preg_match("/^[0-9]{1,2}$/", $id)) {
                        $idError = "<b class='text-danger'>ID Contains at most 2 Numeric characters Allowed</b>";
                    }
                    else {
                        
                        $sql = "SELECT id FROM student";
                        
                        if ($result = mysqli_query($connection, $sql)) 
                        {
                            if(mysqli_num_rows($result) > 0) 
                            {
                                $arr = [];
                                
                                while ($row = mysqli_fetch_array($result)) {
                                    array_push($arr, $row["id"]);
                                }
                                
                                if (!in_array($id, $arr))
                                {
                                    $idError = "<b class='text-danger'> This ID is Not Found. Please Try Different ID.</b>";
                                }
                            }   
                        } 
                    }
                }
            }
        ?>

        <div class="form-container my-5">
            <div id="message"></div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" id="showForm">
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">ID: </label>
                    <div class="col-sm-10">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg" id="id" placeholder="Enter Student ID" name="id" value="<?php echo $id;?>" required>
                            <button name="deleteBtn" type="submit" id="showBtn" class="btn btn-lg btn-primary">Delete Record</button>
                        </div>
                        <span id="idError"><?php echo $idError ?></span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>

    <script>
    <?php
        if (isset($_POST['id'])) {
            if (empty($idError)) 
            {
                echo "location.href = 'delete-inline.php?id=$id'";
            }
        }
    ?>
    </script>

</body>

</html>