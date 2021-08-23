<!doctype html>
<html lang="en">

<head>
    <title>PHP CRUD | CREATE RECORD</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
</head>
<style>
    .form-container {
        width: 80%;
        margin: 0 auto;
        padding: 50px 50px 30px 50px;
        background-color: #F2F2F2;
        border-radius: 10px;
        box-shadow: 0 0 0 18px rgba(0, 0, 0, 0.5), 0 0 18px 0 rgba(0, 0, 0, 0.5);
    }

    .form-container label {
        font-weight: bolder;
        font-size: 20px;
    }
</style>

<body>

    <?php include_once "header.php"; ?>

    <div class="container-lg container-fluid">
        <hr>
        <h1 class="text-center">PHP CRUD APPLICATION <span class="badge bg-secondary">BY BKR</span></h1>
        <hr>
        <h3 class="text-center">CREATE STUDENTS RECORDS</h3>
        <center>
            <hr class="m-0" style="width:15%">
        </center>

        <?php

            include_once "config.php";

            function convert_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                $data = mysqli_real_escape_string($GLOBALS["connection"], $data);
                return $data;
            }

            $name = $address = $course = $phone = "";
            $nameError = $addressError = $courseError = $phoneError = "";
            
            if ((isset($_POST['createBtn']))) {

                if (empty($_POST["name"])) {
                    $nameError = "<b class='text-danger'>* Name is Required</b>";
                }
                else {
                    $name = convert_input($_POST["name"]);
                    
                    if (!preg_match("/^[a-zA-Z ]{3,30}$/",$name)) {
                        $nameError = "<b class='text-danger'>Name Contains at most 30 characters Allowed. No Special & Numeric Chracters is Allowed</b>";
                    }
                }

                if (empty($_POST["address"])) {
                    $addressError = "<b class='text-danger'>* Address is Required</b>";
                }
                else {
                    $address = convert_input($_POST["address"]);
                    
                    if (!preg_match("/^[a-zA-Z0-9 ]{2,200}$/",$address)) {
                        $addressError = "<b class='text-danger'>Address Contains at most 200 characters Allowed. No Special Chracters is Allowed</b>";
                    }
                }

                if (empty($_POST["course"])) {
                    $courseError = "<b class='text-danger'>* Class is Required</b>";
                }
                else {
                    $course = convert_input($_POST["course"]);
                }

                if (empty($_POST["phone"])) {
                    $phoneError = "<b class='text-danger'>* Phone Number is Required</b>";
                }
                else {
                    $phone = convert_input($_POST["phone"]);
                    
                    if (!preg_match("/^[0-9]{11}$/",$phone)) {
                        $phoneError = "<b class='text-danger'> Phone Number must Contains 11 characters Allowed.</b>";
                    }
                    else {

                        $sql = "SELECT stu_phone FROM student";
                        
                        if ($result = mysqli_query($connection, $sql)) 
                        {
                            if(mysqli_num_rows($result) > 0) 
                            {
                                while ($row = mysqli_fetch_array($result)) {
                                    if ($row["stu_phone"] == $phone) {
                                        $phoneError = "<b class='text-danger'> Phone Number is already registered. Please Try Different Number.</b>";  
                                    }
                                }
                            }   
                        }    
                    }
                }
            }            
        ?>

        <div class="form-container my-5">
            <div id="message"></div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Name: </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" placeholder="Enter Student Name" name="name"
                            required value="<?php echo $name;?>">
                        <span id="nameError"><?php echo $nameError ?></span>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="address" class="col-sm-2 col-form-label">Address: </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="address" name="address"
                            placeholder="Enter Student Address" value="<?php echo $address;?>" required>
                        <span id="addressError"><?php echo $addressError ?></span>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="course" class="col-sm-2 col-form-label">Course: </label>
                    <div class="col-sm-10">
                        <select name="course" id="course" class="form-select" required>
                            <option value="">Select Your Course</option>
                            <?php  

                                $sql = "SELECT * FROM course";
                                
                                if ($result = mysqli_query($connection, $sql)) 
                                {
                                    if(mysqli_num_rows($result) > 0) 
                                    {
                                        while($row = mysqli_fetch_array($result)) {
                                            $selected = "";
                                            if ($row["crs_id"] == $course) {
                                                $selected = "selected";
                                            }
                                            else {
                                                $selected = "";
                                            }

                                            echo "<option value='{$row['crs_id']}' $selected>
                                                    {$row['crs_name']} ({$row['crs_code']})
                                                </option>";
                                        }
                                    }
                                }            
                            ?>

                        </select>
                        <span id="classError"><?php echo $courseError ?></span>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="phone" class="col-sm-2 col-form-label">Phone: </label>
                    <div class="col-sm-10">
                        <input type="text" name="phone" class="form-control" id="phone"
                            placeholder="Enter Student Phone" required value="<?php echo $phone;?>">
                        <span id="phoneError"><?php echo $phoneError ?></span>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button name="createBtn" type="submit" id="createBtn" class="btn btn-lg btn-primary">Create Record</button>
                </div>
            </form>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js">
    </script>

    <?php
        if (isset($_POST['createBtn'])) {

            if (empty($nameError) && empty($addressError) && empty($courseError) && empty($phoneError)) {

                $sql = "INSERT INTO student (stu_name, stu_phone, stu_address, course_id) VALUES ('{$name}', '{$phone}', '{$address}', '{$course}');";
            
                mysqli_query($connection, $sql) or die("Query Unsuccessfull");
    
                echo "<script>location.href='index.php'</script>";
            }
        }
    ?>
    
</body>

</html>