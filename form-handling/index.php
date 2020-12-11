<!doctype html>
<html lang="en">

<head>
    <title>Form Handling</title>
    
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <h1 style="font-size: 1.5rem;">PHP Form Handling</h1>
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
        function convert_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        
        $name = $email = $website = $massage = $gender = "";
        $nameError = $emailError = $websiteError = $massageError = $genderError = "";

        if ((isset($_POST['submit-btn']))) {

            if (empty($_POST["name"])) {
                $nameError = "<b class='text-danger'>* Name is Required</b>";
            }
            else {
                $name = convert_input($_POST["name"]);
                
                if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                    $nameError = "<b class='text-danger'>Only Letters and WhiteSpaces Allowed</b>";;
                }
            }

            if (empty($_POST["email"])) {
                $emailError = "<b class='text-danger'>* Email is Required</b>";
            }
            else {
                $email = convert_input($_POST["email"]);
                
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailError = "<b class='text-danger'>Invalid email format</b>";
                }
            }

            if (empty($_POST["website"])) {
                $websiteError = "";
                $website = "";
            }
            else {
                $website = convert_input($_POST["website"]);

                if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
                    $websiteError = "<b class='text-danger'>Your Website URL is Invalid</b>";
                }
            }

            if (empty($_POST["massage"])) {
                $massageError = "<b class='text-danger'>* Massage is Required</b>";
            }
            else {
                $massage = convert_input($_POST["massage"]);
            }

            if (empty($_POST["gender"])) {
                $genderError = "<b class='text-danger'>* Gender is Required</b>";
            }
            else {
                $gender = convert_input($_POST["gender"]);
            }
        }
    ?>

    <div class="w-75 mx-auto mt-3">
        <hr>
        <h1>PHP Complete Form Handling</h1>
        <hr>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" value="<?php echo $name;?>" class="form-control" id="name" name="name"
                        placeholder="Enter Your Name">
                    <span id="name-error"><?php echo $nameError ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" value="<?php echo $email;?>" class="form-control" id="email" name="email"
                        placeholder="Enter Your Email">
                    <span id="email-error"><?php echo $emailError ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Website</label>
                <div class="col-sm-10">
                    <input type="text" value="<?php echo $website;?>" class="form-control" id="website" name="website"
                        placeholder="Enter Your Company">
                    <span id="website-error"><?php echo $websiteError ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-sm-2 pt-0">Massage</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="massage" name="massage" rows="5"
                        placeholder="Enter Your Massage Here"><?php echo $massage ?></textarea>
                    <span id="massage-error"><?php echo $massageError ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="radios" class="col-sm-2 col-form-label">Gender</label>
                <div id="radios" class="col-sm-10 d-flex align-items-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="radio-1" value="Male"
                            <?php if (isset($gender) && $gender == "Male") echo "checked" ?>>
                        <label class="form-check-label" for="radio-1">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="radio-2" value="Female"
                            <?php if (isset($gender) && $gender == "Female") echo "checked" ?>>
                        <label class="form-check-label" for="radio-2">Female</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="radio-3" value="Other"
                            <?php if (isset($gender) && $gender == "Other") echo "checked" ?>>
                        <label class="form-check-label" for="radio-3">Other</label>
                    </div>
                    <span id="gender-error"><?php echo $genderError ?></span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" id="submit-btn" name="submit-btn" class="btn btn-primary">Submit
                        Details</button>
                </div>
            </div>
        </form>

        <hr>
        <h1>Your Input :- </h1>
        <hr>
        <p>
            <?php
                if ((isset($_POST['submit-btn'])) && $nameError == "" && $emailError == "" && $websiteError == "" && $massageError == "" && $genderError == "") {
                    echo "<b>Name : </b>" . $name;
                    echo "<br>";
                    echo "<b>Email : </b>" . $email;
                    echo "<br>";
                    echo "<b>Website : </b>" . $website;
                    echo "<br>";
                    echo "<b>Massage : </b>" . $massage;
                    echo "<br>";
                    echo "<b>Gender : </b>" . $gender;
                }
                else {
                    echo "Nothing to Show Here. Please Enter Some Details on Above Form and Viewing your details";
                }
            ?>
        </p>
    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>