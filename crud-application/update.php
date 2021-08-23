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

    <?php include_once "header.php"; ?>

    <div class="container-lg container-fluid">
        <hr>
        <h1 class="text-center">PHP CRUD APPLICATION <span class="badge bg-secondary">BY BKR</span></h1>
        <hr>
        <h3 class="text-center">UPDATE STUDENTS RECORDS</h3>
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

            $id = $idError = "";

            if (isset($_POST['showBtn'])) {
                if (empty($_POST["id"])) {
                    $idError = "<b class='text-danger'>* ID is Required</b>";
                }
                else {
                    $id = convert_input($_POST["id"]);
                    
                    if (!preg_match("/^[0-9]{1,2}$/", $id)) {
                        $idError = "<b class='text-danger'>ID Contains at most 2 Numeric characters Allowed</b>";
                    }
                    else {
                        
                        $sql = "SELECT stu_name FROM student WHERE stu_id = $id";
                        
                        if ($result = mysqli_query($connection, $sql)) 
                        {   
                            if(!mysqli_num_rows($result)) {
                                $idError = "<b class='text-danger'> This ID is Not Found. Please Try Different ID.</b>";
                            }   
                        } 
                        else {
                            echo "connection faild: " . mysqli_error($connection);     
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
                            <input type="text" class="form-control form-control-lg" id="id" placeholder="Enter Student ID" name="id" required value="<?php echo $id;?>">
                            <button name="showBtn" type="submit" id="showBtn" class="btn btn-lg btn-primary">Show Record</button>
                        </div>
                        <span id="idError"><?php echo $idError ?></span>
                    </div>
                </div>
            </form>

            <?php
                if (isset($_POST['showBtn'])) {

                    if (empty($idError)) {

                    $sql = "SELECT stu_id, stu_name, stu_phone, stu_address, course_id, crs_id, crs_name, crs_code FROM student AS stu INNER JOIN course AS crs where stu.course_id = crs.crs_id AND stu.stu_id = $id";

                    if ($result = mysqli_query($connection, $sql)) 
                    {
                        if(mysqli_num_rows($result) > 0) 
                        {
                            while ($row = mysqli_fetch_array($result)) {
            ?>

            <form method="post" id="updateForm" action="updateData.php">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Name: </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" placeholder="Enter Student Name" name="name" value="<?php echo $row['stu_name'] ?>" required>
                        <span class="nameError"></span>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="address" class="col-sm-2 col-form-label">Address: </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['stu_address'] ?>" placeholder="Enter Student Address" required>
                        <span class="addressError"></span>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="course" class="col-sm-2 col-form-label">Course: </label>
                    <div class="col-sm-10">
                        <select name="course" id="course" class="form-select" required>
                            <option value="NULL">Select Your Course</option>
                            <?php  
                                $sql = "SELECT * FROM course";
                                
                                if ($result = mysqli_query($connection, $sql)) 
                                {
                                    if(mysqli_num_rows($result) > 0) 
                                    {
                                        while($innerRow = mysqli_fetch_array($result)) {
                                            $selected = "";
                                            if ($innerRow["crs_id"] == $row["course_id"]) {
                                                $selected = "selected";
                                            }
                                            else {
                                                $selected = "";
                                            }

                                            echo "<option value='{$innerRow['crs_id']}' $selected>
                                                    {$innerRow['crs_name']} ({$innerRow['crs_code']})
                                                </option>";
                                        }
                                    }   
                                }
                                else {
                                    echo "connection faild: " . mysqli_error($connection);     
                                }          
                                ?>
                        </select>
                        <span class="courseError"></span>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="phone" class="col-sm-2 col-form-label">Phone: </label>
                    <div class="col-sm-10">
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter Student Phone" required value="<?php echo $row['stu_phone'] ?>">
                        <span class="phoneError"></span>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button name="updateBtn" type="submit" id="updateBtn" class="btn btn-lg btn-primary">Update Record</button>
                </div>

                <input type="hidden" name="checkUpdate" value="checkUpdate">
            </form>

                            
            <?php } } } } } ?>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>

    <script>
        function addLiveEventListeners(selector, event, handler){
            document.querySelector("body").addEventListener(event, 
            function(event) {
                var target = event.target;
                while (target != null) {
                    var isMatch = target.matches(selector);
                    
                    if (isMatch) {
                        handler(event);
                        return;
                    }
                    
                    target = target.parentElement;
                }
            }, true);
        }

        addLiveEventListeners("#updateBtn", "click" , function (event) 
        {
            event.preventDefault();
        
            let name = document.getElementById("name");
            let address = document.getElementById("address");
            let course = document.getElementById("course");
            let phone = document.getElementById("phone");
            
            let nameError = document.querySelector(".nameError");
            let addressError = document.querySelector(".addressError");
            let courseError = document.querySelector(".courseError");
            let phoneError = document.querySelector(".phoneError");
            
            let check = {"name": false, "address": false, "course": false, "phone": false }; 
            
            let regxForName = /^[a-zA-Z0-9 ]{2,20}$/;
            let regxForAddress = /^[a-zA-Z0-9 ]{2,225}$/;
            let regxForPhone = /^[0-9]{11}$/;

            <?php
                $sql = "SELECT stu_phone FROM student INNER JOIN course WHERE course_id = crs_id AND stu_id = $id";

                $currentphone = "";
                
                if (!empty($id)) {
                    if ($result = mysqli_query($connection, $sql)) 
                    {
                        if(mysqli_num_rows($result) > 0) 
                        {
                            while ($row = mysqli_fetch_array($result)) {
                                $currentphone = $row["stu_phone"]; 
                            }
                        }
                    }
                    else {
                        echo "connection faild: " . mysqli_error($connection);     
                    }
                }
            
                $sql = "SELECT stu_phone FROM student;";

                echo "let dbphone = [];
                      let currentphone = '$currentphone';";
                
                if ($result = mysqli_query($connection, $sql)) 
                {
                    if(mysqli_num_rows($result) > 0) 
                    {
                        while($row = mysqli_fetch_array($result)) {
                            echo "\n\t\t\t\t\t\tdbphone.push('{$row['stu_phone']}');";
                        }
                    }   
                }
                else {
                    echo "connection faild: " . mysqli_error($connection);     
                }               
            ?>
            
            
            for( var i = 0; i < dbphone.length; i++) { 
                if ( dbphone[i] == currentphone) { 
                    dbphone.splice(i, 1);
                }
            }

            if (!regxForName.test(name.value)) {
                nameError.innerHTML = `<b class="text-danger">Error: Name must be less than or equal to 30 chracters. Special Characters is Not Allowed</b>`;
                check["name"] = false;
            }
            else if (regxForName.test(name.value)) {
                nameError.innerHTML = "";
                check["name"] = true;
            }
            
            if (!regxForAddress.test(address.value)) {
                addressError.innerHTML = `<b class="text-danger">Error: Address must be less than or equal to 225 chracters. Special Characters is Not Allowed</b>`;
                check["address"] = false;
            }
            else if (regxForAddress.test(address.value)) {
                addressError.innerHTML = "";
                check["address"] = true;
            }

            if (!regxForPhone.test(phone.value)) {
                phoneError.innerHTML = `<b class="text-danger">Error: phone must be equal to 11 chracters. Only Numeric Characters is Allowed</b>`;
                check["phone"] = false;
            }
            else if (regxForPhone.test(phone.value)) {
                if (dbphone.includes(phone.value)) {
                    phoneError.innerHTML = `<b class="text-danger">Error: phone must be Unique. This Phone Number is Already Registered</b>`;
                    check["phone"] = false;
                }
                else if (!dbphone.includes(phone.value)) {
                    phoneError.innerHTML = "";
                    check["phone"] = true;
                }
            }
            
            if (course.value == "" || course.value == "NULL") {
                courseError.innerHTML = `<b class="text-danger">Error: Please Select Options From Any One of Them.</b>`;
                check["course"] = false;
            }
            else if (course.value != "NULL") {
                courseError.innerHTML = "";
                check["course"] = true;
            }

            console.log(check);

            if (Object.values(check).every((elem)=> {return elem == true})) {
                document.getElementById("updateForm").submit();
            } 
        });
    </script>

</body>

</html>