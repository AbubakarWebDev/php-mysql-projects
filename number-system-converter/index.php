<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number System Conversion</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css" />

    <style>
    .main-container {
        background-color: #343A40;
        padding: 20px;
        border-radius: 10px;
    }

    form label {
        color: #FFDC42 !important;
        font-size: 20px !important;
        font-weight: bolder !important;
    }

    .btn-custom {
        background-color: #FFDC42 !important;
    }

    .text-custom {
        color: #499ff9 !important;
    }

    .form-control {
        font-size:20px !important;
        font-weight:600 !important;
        color:black !important;
    }


    </style>
</head>

<body>
    <!-- Application Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <h1 style="font-size: 1.5rem;">Number System Conversion</h1>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
                        <a class="nav-link"
                            href="https://abubakarwebdev.github.io/webapplications/#privacypolicy">Privacy Policy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="https://abubakarwebdev.github.io/webapplications/#disclaimer">Disclaimer</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <?php 
        function convert_input($input) {
            $input = stripslashes($input);
            $input = trim($input);
            $input = htmlspecialchars($input);
            return $input;
        }

        function check_binary($input) {
            for ($i=0; $i < strlen($input); $i++) { 
                if ($input[$i] != "0" && $input[$i] != "1") {
                    return false;
                }
            }

            return true;
        }

        function check_octal($input) {
            for ($i=0; $i < strlen($input); $i++) { 
                if ($input[$i] >= "8") {
                    return false;
                }
            }

            return true;
        }


        function check_hex($input) {
            if (preg_match("/[^(0-9a-f)]/mi",$input)) {
                return false;
            }

            return true;
        }
        
        $binary = $decimal = $octal = $hex = "";
        $binaryError = $decimalError = $octalError = $hexError = "";
        
        if (isset($_POST["binaryConvert"])) {
            if (empty($_POST["binaryInput"])) {
                $binaryError = "<b class='text-custom'>Error: Input is Empty!</b>";
            }
            else {
                $binary = convert_input($_POST["binaryInput"]);

                if (!is_numeric($binary)) {
                    $binaryError = "<b class='text-custom'>Error: Input is Not a Number!</b>";
                }
                else {
                    if (!check_binary($binary)) {
                        $binaryError = "<b class='text-custom'>Error: Input is Not a Binary Number!</b>";
                    }
                    else {
                        $decimal = base_convert($binary, 2, 10);
                        $octal = base_convert($binary, 2, 8);
                        $hex = strtoupper(base_convert($binary, 2, 16));
                    }
                }
            }
        }
        
        else if (isset($_POST["decimalConvert"])) {
            if (empty($_POST["decimalInput"])) {
                $decimalError = "<b class='text-custom'>Error: Input is Empty!</b>";
            }
            else {
                $decimal = convert_input($_POST["decimalInput"]);

                if (!is_numeric($decimal)) {
                    $decimalError = "<b class='text-custom'>Error: Input is Not a Number!</b>";
                }
                else {
                    $binary = base_convert($decimal, 10, 2);
                    $octal = base_convert($decimal, 10, 8);
                    $hex = strtoupper(base_convert($decimal, 10, 16));
                }
            }
        }

        else if (isset($_POST["octalConvert"])) {
            if (empty($_POST["octalInput"])) {
                $octalError = "<b class='text-custom'>Error: Input is Empty!</b>";
            }
            else {
                $octal = convert_input($_POST["octalInput"]);

                if (!is_numeric($octal)) {
                    $octalError = "<b class='text-custom'>Error: Input is Not a Number!</b>";
                }
                else {
                    if (!check_octal($octal)) {
                        $octalError = "<b class='text-custom'>Error: Input is Not a Octal Number!</b>";
                    }
                    else {
                        $binary = base_convert($octal, 8, 2);
                        $decimal = base_convert($octal, 8, 10);
                        $hex = strtoupper(base_convert($octal, 8, 16));
                    }
                }
            }
        }

        else if (isset($_POST["hexConvert"])) {
            if (empty($_POST["hexInput"])) {
                $hexError = "<b class='text-custom'>Error: Input is Empty!</b>";
            }
            else {
                $hex = strtoupper(convert_input($_POST["hexInput"]));

                if (!check_hex($hex)) {
                    $hexError = "<b class='text-custom'>Error: Input is Not a HexaDecimal Number!</b>";
                }
                else {
                    $binary = base_convert($hex, 16, 2);
                    $octal = base_convert($hex, 16, 8);
                    $decimal = base_convert($hex, 16, 10);
                }
            }
        }

        else {
            $binary = $decimal = $octal = $hex = "";
            $binaryError = $decimalError = $octalError = $hexError = "";
        }        
    ?>

    <div class="container">
        <hr>
        <h1 class="text-center">Number Base Converter</h1>
        <p class="text-center">Enter a number in one of the text boxes and press the Convert button:</p>
        <hr>
        <div class="container main-container">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                <div class="row my-4">
                    <div class="col-md-4 text-lg-center">
                        <label class="mb-md-0 mb-2">Binary Number : </label>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="text" name="binaryInput" class="form-control" value="<?php echo $binary ?>"
                                    placeholder="Enter Binary Number" />
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-custom mt-sm-0 mt-3" name="binaryConvert"
                                    type="submit">Convert</button>
                            </div>
                        </div>
                        <?php echo $binaryError ?>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-md-4 text-lg-center">
                        <label class="mb-md-0 mb-2">Decimal Number : </label>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="text" name="decimalInput" class="form-control"
                                    value="<?php echo $decimal ?>" placeholder="Enter Decimal Number" />
                            </div>
                            <div class="col-sm-4">
                                <button name="decimalConvert" class="btn btn-custom mt-sm-0 mt-3"
                                    type="submit">Convert</button>
                            </div>
                            <?php echo $decimalError ?>
                        </div>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-md-4 text-lg-center">
                        <label class="mb-md-0 mb-2">Octal Number : </label>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="octalInput" value="<?php echo $octal ?>"
                                    placeholder="Enter Octal Number" />
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-custom mt-sm-0 mt-3" name="octalConvert"
                                    type="submit">Convert</button>
                            </div>
                        </div>
                        <?php echo $octalError ?>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-md-4 text-lg-center">
                        <label class="mb-md-0 mb-2">HexDec Number : </label>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="hexInput" value="<?php echo $hex ?>"
                                    placeholder="Enter HexaDecimal Number" />
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-custom mt-sm-0 mt-3" name="hexConvert"
                                    type="submit">Convert</button>
                            </div>
                        </div>
                        <?php echo $hexError ?>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="mt-2 btn btn-custom btn-lg">Reset All Inputs</button>
                </div>
            </form>
        </div>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
</body>

</html>