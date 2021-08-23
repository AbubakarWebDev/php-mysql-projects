<?php

    function fetchRecords() 
    {
        include_once "config.php";
        
        if ($_POST["name"] == "country") 
        {
            $sql = "SELECT id, name FROM countries";

            $result = mysqli_query($connection, $sql) or die(json_encode(array("error" => "Query Unsucessfull", "message" => mysqli_error($connection), "status" => false), JSON_PRETTY_PRINT));
            
            if(mysqli_num_rows($result) > 0) 
            {
                $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $array["status"] = "true";
                echo json_encode($array, JSON_PRETTY_PRINT);
                return;
            }     
        }
        else if ($_POST["name"] == "state") {
            $sql = "SELECT id, name FROM states WHERE country_id = {$_POST['country_id']}";

            $result = mysqli_query($connection, $sql) or die(json_encode(array("error" => "Query Unsucessfull", "message" => mysqli_error($connection), "status" => false), JSON_PRETTY_PRINT));
            
            if(mysqli_num_rows($result) > 0) 
            {
                $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $array["status"] = "true";
                echo json_encode($array, JSON_PRETTY_PRINT);
                return;
            } 
        }
        else if ($_POST["name"] == "city") {
            $sql = "SELECT id, name FROM cities WHERE state_id = {$_POST['state_id']}";

            $result = mysqli_query($connection, $sql) or die(json_encode(array("error" => "Query Unsucessfull", "message" => mysqli_error($connection), "status" => false), JSON_PRETTY_PRINT));
            
            if(mysqli_num_rows($result) > 0) 
            {
                $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $array["status"] = "true";
                echo json_encode($array, JSON_PRETTY_PRINT);
                return;
            } 
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") 
    {
        fetchRecords();
    }
?>