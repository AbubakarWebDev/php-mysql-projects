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

    <?php require "header.php"; ?>

    <div class="container-lg container-fluid">
        <hr>
        <h1 class="text-center">PHP CRUD APPLICATION <span class="badge bg-secondary">BY BKR</span></h1>
        <hr>
        <h3 class="text-center">UPDATE STUDENTS RECORD</h3>
        <center>
            <hr class="m-0" style="width:15%">
        </center>

        <?php

        $id = "";

        if (isset($_GET['id'])) {

            include "config.php";

            $id = $_GET['id'];

            $sql = "SELECT id, name, phone, class, address FROM student INNER JOIN class where class = cid AND id = $id";

            if ($result = mysqli_query($connection, $sql)) 
            {
                if(mysqli_num_rows($result) > 0) 
                {
                    while ($row = mysqli_fetch_array($result)) {
        ?>

        <div class="form-container my-5">
        <form method="post" id="updateForm" action="updateData.php">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Name: </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" placeholder="Enter Student Name" name="name" value="<?php echo $row['name'] ?>" required>
                        <span class="nameError"></span>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="address" class="col-sm-2 col-form-label">Address: </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address'] ?>" placeholder="Enter Student Address" required>
                        <span class="addressError"></span>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="class" class="col-sm-2 col-form-label">Class: </label>
                    <div class="col-sm-10">
                        <select name="class" id="class" class="form-select" required>
                            <option value="">Select Your Class</option>
                            <?php  
                                $sql = "SELECT * FROM class";
                                
                                if ($result = mysqli_query($connection, $sql)) 
                                {
                                    if(mysqli_num_rows($result) > 0) 
                                    {
                                        while($innerRow = mysqli_fetch_array($result)) {
                                            $selected = "";
                                            if ($innerRow["cid"] == $row["class"]) {
                                                $selected = "selected";
                                            }
                                            else {
                                                $selected = "";
                                            }

                                            echo "<option value='{$innerRow['cid']}' $selected>{$innerRow['cname']}</option>";
                                        }
                                    }   
                                }            
                            ?>
                        </select>
                        <span class="studentClassError"></span>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="phone" class="col-sm-2 col-form-label">Phone: </label>
                    <div class="col-sm-10">
                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter Student Phone" required value="<?php echo $row['phone'] ?>">
                        <span class="phoneError"></span>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button name="updateBtn" type="submit" id="updateBtn" class="btn btn-lg btn-primary">Update Record</button>
                </div>

                <input type="hidden" name="checkUpdate" value="checkUpdate">
            </form>

            <?php } } } } ?>
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

        addLiveEventListeners("#updateBtn", "click" , function (event) {

            event.preventDefault();

            let name = document.getElementById("name");
            let address = document.getElementById("address");
            let studentClass = document.getElementById("class");
            let phone = document.getElementById("phone");
            
            let nameError = document.querySelector(".nameError");
            let addressError = document.querySelector(".addressError");
            let studentClassError = document.querySelector(".studentClassError");
            let phoneError = document.querySelector(".phoneError");
            
            let check = {"name": false, "address": false, "studentClass": false, "phone": false }; 
            
            let regxForName = /^[a-zA-Z0-9 ]{2,20}$/;
            let regxForAddress = /^[a-zA-Z0-9 ]{2,225}$/;
            let regxForPhone = /^[0-9]{11}$/;

            <?php  

                $sql = "SELECT phone FROM student INNER JOIN class where class = cid AND id = $id";

                $currentphone = "";

                if ($result = mysqli_query($connection, $sql)) 
                {
                    if(mysqli_num_rows($result) > 0) 
                    {
                        while ($row = mysqli_fetch_array($result)) {
                            $currentphone = $row["phone"]; 
                        }
                    }
                }
            
                $sql = "SELECT phone FROM student";

                echo "let dbphone = []; let currentphone = '$currentphone';";
                
                if ($result = mysqli_query($connection, $sql)) 
                {
                    if(mysqli_num_rows($result) > 0) 
                    {
                        while($row = mysqli_fetch_array($result)) {
                            echo "dbphone.push('{$row['phone']}');"; 
                        }
                    }   
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
            
            if (studentClass.value == "") {
                studentClassError.innerHTML = `<b class="text-danger">Error: Please Select Options From Any One of Them.</b>`;
                check["studentClass"] = false;
            }
            else if (studentClass.value != "NULL") {
                studentClassError.innerHTML = "";
                check["studentClass"] = true;
            }

            if (Object.values(check).every((elem)=> {return elem == true})) {
                document.getElementById("updateForm").submit();
            } 
        });
    </script>
    
</body>

</html>