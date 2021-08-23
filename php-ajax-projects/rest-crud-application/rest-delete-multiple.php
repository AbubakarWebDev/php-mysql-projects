<?php

    // In responses, a Content-Type header tells the client what the content type of the returned content actually is. Below Header states that our server sending json file to client.
    header("Content-Type: application/json");  
    
    // Access-Control-Allow-Origin is a CORS (Cross-Origin Resource Sharing) header. When Site A tries to fetch content from Site B, Site B can send an Access-Control-Allow-Origin response header to tell the browser that the content of this page is accessible to certain origins. Below Header states that Our Rest Api is Accessed By Anyone.
    header("Access-Control-Allow-Origin: *");  
    
    // The Access-Control-Allow-Methods header is a  Cross-Origin Resource Sharing(CORS) response-type header. It is used to indicate which HTTP methods are permitted while accessing the resources in response to the cross-origin requests. Below Header states that Our Rest Api Supports only the  DELETE" request methods.
    header("Access-Control-Allow-Methods: DELETE");  

    // The Access-Control-Allow-Headers response header is used in response to a CORS request which includes the Access-Control-Request-Headers to indicate which HTTP headers can be used during the actual request. This header is required if the request has an Access-Control-Request-Headers header. Below Header states that Our Rest Api indicate following headers can be used during the client request.
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With"); 

    // Json Decode convert incomming json data to object by default but when we add second parameter true. It will be convert incoming json data to php associative array.
    $data = json_decode(file_get_contents("php://input"), true);
    
    // When The Sending JSON by Client is Not Valid
    if (!$data) {
        goto label;
    }
    
    // Connection With Database
    include_once "config.php";

    // Checking the entered id is exist on database or not
    foreach ($data as $arr) {
        $sql = "SELECT * FROM person WHERE ID = {$arr['id']};";

        if ($result = mysqli_query($connection, $sql)) {
            if (mysqli_num_rows($result) == 0) 
            {
                die(json_encode(array("message" => "Your Entered ID = {$arr['id']} Not Exist On Dataase. Please Try Different ID!", "status" => false), JSON_PRETTY_PRINT));
            }
        }
        else {
            die(json_encode(array("error" => "Query Unsucessfull", "message" => mysqli_error($connection), "status" => false), JSON_PRETTY_PRINT));
        }
    }

    $sql = "";
    
    // Multiple SQL Query For Deleting Records On Database
    foreach ($data as $arr) {
        $sql .= "DELETE FROM person WHERE ID = {$arr['id']};";
    }

    if ($result = mysqli_multi_query($connection, $sql) or die(json_encode(array("error" => "Query Unsucessfull", "message" => mysqli_error($connection), "status" => false), JSON_PRETTY_PRINT))) 
    {
        echo json_encode(array("message" => "Your Records is Deleted Successfully!", "status" => true), JSON_PRETTY_PRINT);
    }
    else {
        label:
        echo json_encode(array("message" => "Your Sending Data is Not Valid JSON!", "status" => false), JSON_PRETTY_PRINT);
    }

?>