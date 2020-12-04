<!doctype html>
<html lang="en">

<head>
    <title>PHP Calculator</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<style>
body {
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgb(131, 58, 180);
    background: linear-gradient(90deg, rgba(131, 58, 180, 1) 0%, rgba(253, 29, 29, 1) 50%, rgba(252, 176, 69, 1) 100%);
}

#main {
    width: 600px;
    height: 400px;
    border-radius: 35px;
    box-shadow: 3px 3px 20px 0px #940000;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
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

        $tempreture = $radio = $radioError = $tempretureError = $result = "";

        if (isset($_POST["btn"])) {
            if (empty($_POST["tempreture"])) {
                $tempretureError = "<b>* This Field is Required</b>";
            }
            else {
                $tempreture = convert_input($_POST["tempreture"]);
                
                if (!is_numeric($tempreture)) {
                    $tempretureError = "<b>The Input You Have Entered is Not a Number<b>";
                }
            }

            if (empty($_POST["temp-radio"])) {
                $radioError = "<b>* This Field is Required</b>";
            }
            else {
                $radio = convert_input($_POST["temp-radio"]);
            }
        }

        if ($radioError == "" && $tempretureError == "") {
            if ($radio == "Fahrenheit") {
                $solution = round((($tempreture - 32) * 5 / 9) , 1);
                $result = "<h4>Your Fahrenheit Tempreture is : $solution</h3>";
            }
            if ($radio == "Celsius") {
                $solution = round((($tempreture * 9 / 5) + 32) , 1);
                $result = "<h4>Your Celsius Tempreture is : $solution</h3>";
            }
        }
    ?>

    <div id="main" class="container bg-light">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>"
            class="text-center w-50 mx-auto">
            <div class="form-group">
                <label for="tempreture">Tempreture</label>
                <input type="text" class="form-control" name="tempreture" id="tempreture"
                    placeholder="Enter Your Tempreture" value="<?php echo $tempreture ?>">
                <div class="mt-1 text-danger"><?php echo $tempretureError ?></div>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" <?php if(isset($radio) && $radio == "Celsius") echo "checked" ?>
                    type="radio" name="temp-radio" id="Radio1" value="Celsius">
                <label class="form-check-label" for="Radio1">Celsius</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" <?php if(isset($radio) && $radio == "Fahrenheit") echo "checked" ?>
                    type="radio" name="temp-radio" id="Radio2" value="Fahrenheit">
                <label class="form-check-label" for="Radio2">Fahrenheit</label>
            </div>
            <div class="mt-1 text-danger"><?php echo $radioError ?></div>

            <div class="form-group row mt-3">
                <div class="col-sm-12">
                    <button type="submit" name="btn" class="btn btn-primary">Convert Now</button>
                </div>
            </div>
        </form>
        <?php echo $result ?>
    </div>

</body>

</html>