<?php

    function getData($range1, $range2) {
        include_once "config.php";

        $sql = "SELECT name, phone_code, capital, tld, native FROM countries WHERE id BETWEEN $range1 AND $range2";
    
        if ($result = mysqli_query($connection, $sql) or die(json_encode(array("error" => "Query Unsucessfull", "message" => mysqli_error($connection), "status" => false), JSON_PRETTY_PRINT)))
        {
            if (mysqli_num_rows($result) > 0) 
            {
                $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
                echo json_encode($output, JSON_PRETTY_PRINT);
            }
            else 
            {
                echo json_encode(array("message" => "No Records Found!", "status" => false), JSON_PRETTY_PRINT);
            }
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST["range1"]) && isset($_POST["range2"])) {
            getData($_POST["range1"], $_POST["range2"]);
        }
        else {
            echo "<h1 style='color: red'>Nice Try!<h1>";
        }
    }
    else {
        echo "<h1 style='color: red'>Something Went Wrong!<h1>";
    }
?>