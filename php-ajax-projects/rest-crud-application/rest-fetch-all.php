<?php 
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    include_once "config.php";

    $sql = "SELECT * FROM person";

    if ($result = mysqli_query($connection, $sql) or die(json_encode(array("error" => "Query Unsucessfull", "message" => mysqli_error($connection), "status" => false), JSON_PRETTY_PRINT))) {
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
?>