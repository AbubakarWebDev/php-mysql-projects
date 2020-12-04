<!doctype html>
<html lang="en">

<head>
    <title>PHP Calculator</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<style>
body 
{
    background-color: #FFDC42;
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

#main {
    background-color: #414141;
    height: 70vh;
    border-radius: 50px;
    box-shadow: 1px 5px 12px 1px black;
}

#form-section {
    width: 100%;
    height: 60vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.number-inp {
    height: 50px;
    background: none;
    text-align: center;
    color: white;
    border: none;
    font-size: 20px;
    width: 300px;
    outline: none;
    border-bottom: 2px solid #FFDC42;
    border-radius: 1px;
}

.number-inp::placeholder {
    color: white;
}

.custom {
    width: 300px !important;
    height: 40px !important;
    font-size: 20px !important;
    padding: 5px !important;
}

.btn-custom {
    background-color: #FFDC42 !important;
}

.btn-custom:hover {
    background-color: #d5b62f !important;
}

#heading {
    display: flex;
    justify-content: flex-start;
    align-items: center;
}

h1 {
    color: #FFDC42;
    border-left: 5px solid #FFDC42;
    padding-left: 20px;
    font-size: 60px;
    margin-left: 50px;
}
</style>

<body>
    <?php 
        function convert_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        
        $number_1 = $number_2 = $operation = $result = "";
        $number_1_error = $number_2_error = $operation_error = "";

        if (isset($_POST["btn"])) {
            if ($_POST["number-1"] == "") {
                $number_1_error = "<b>* This Field is Required</b>";
            }
            else {
                $number_1 = convert_input($_POST["number-1"]);
                
                if (!is_numeric($number_1)) {
                    $number_1_error =  "<b>The Input you have Enter is Not a Number</b>";
                }
            }

            if ($_POST["number-2"] == "") {
                $number_2_error = "<b>* This Field is Required</b>";
            }
            else {
                $number_2 = convert_input($_POST["number-2"]);
                
                if (!is_numeric($number_2)) {
                    $number_2_error =  "<b>The Input you have Enter is Not a Number</b>";
                }
            }

            if (empty($_POST["operation"])) {
                $operation_error = "<b>* This Field is Required</b>";
            }
            else {
                $operation = $_POST["operation"];
            }
        }

        if ($number_1_error == "" && $number_2_error == "" && $operation_error == "") {
            if ($operation == "+") {
                $solution = $number_1 + $number_2;
                $result = "<h3 class='text-center text-white'>The Addition of Two Numbers is : $solution</h3>";
            }
            else if ($operation == "-") {
                $solution = $number_1 - $number_2;
                $result = "<h3 class='text-center text-white'>The Subtraction of Two Numbers is : $solution</h3>";
            }
            else if ($operation == "*") {
                $solution = $number_1 * $number_2;
                $result = "<h3 class='text-center text-white'>The Multipication of Two Numbers is : $solution</h3>";
            }
            else if ($operation == "/") {
                if ($number_2 == "0" && $operation == "/") {
                    $solution = "Infinity";
                    $result = "<h3 class='text-center text-white'>The Division of Two Numbers is : $solution</h3>"; 
                }
                else {
                    $solution = $number_1 / $number_2;
                    $result = "<h3 class='text-center text-white'>The Division of Two Numbers is : $solution</h3>";
                }
            }
        }
    ?>

    <div id="main" class="container">
        <div class="row">
            <div id="heading" class="col-md-6">
                <h1>PHP<br>Calculator</h1>
            </div>
            <div id="form-section" class="col-md-6">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>"
                    class="d-flex justify-content-center flex-column align-items-center">
                    <div class="form-group">
                        <input class="number-inp" name="number-1" type="text" placeholder="Enter Your Number"
                            value="<?php echo $number_1 ?>">
                        <div class="mt-1 text-warning"><?php echo $number_1_error ?></div>
                    </div>
                    <div class="form-group">
                        <input class="number-inp" name="number-2" type="text" placeholder="Enter Your Number"
                            value="<?php echo $number_2 ?>">
                        <div class="mt-1 text-warning"><?php echo $number_2_error ?></div>
                    </div>
                    <div class="form-group">
                        <select class="form-control custom" name="operation">
                            <option value="" <?php if(isset($operation) && $operation == "") echo "selected" ?>> Select
                                Operation </option>
                            <option value="+" <?php if(isset($operation) && $operation == "+") echo "selected" ?>>
                                Addition</option>
                            <option value="-" <?php if(isset($operation) && $operation == "-") echo "selected" ?>>
                                Subtraction</option>
                            <option value="*" <?php if(isset($operation) && $operation == "*") echo "selected" ?>>
                                Multipication</option>
                            <option value="/" <?php if(isset($operation) && $operation == "/") echo "selected" ?>>
                                Division</option>
                        </select>
                        <div class="mt-1 text-warning"><?php echo $operation_error ?></div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-custom" name="btn" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php echo $result ?>
            </div>
        </div>
    </div>
</body>

</html>