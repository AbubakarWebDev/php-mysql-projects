<?php 

    include_once "config.php";

    $search_term = $_POST["searchTerm"];

    $sql = "SELECT name, phone_code, capital, tld, native from countries WHERE name LIKE '%{$search_term}%'";

    if ($result = mysqli_query($connection, $sql) or die(json_encode(array("error" => "Query Unsucessfull", "message" => mysqli_error($connection), "status" => false), JSON_PRETTY_PRINT))) {
        if (mysqli_num_rows($result) > 0) 
        {
            $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $output["status"] = true;
            echo json_encode($output, JSON_PRETTY_PRINT);
        }
        else 
        {
            echo json_encode(array("message" => "No Records Found!", "status" => false), JSON_PRETTY_PRINT);
        }
    }
?>