<?php 

    // In responses, a Content-Type header tells the client what the content type of the returned content actually is. Below Header states that our server sending json file to client.
    header("Content-Type: application/json");

    // Access-Control-Allow-Origin is a CORS (Cross-Origin Resource Sharing) header. When Site A tries to fetch content from Site B, Site B can send an Access-Control-Allow-Origin response header to tell the browser that the content of this page is accessible to certain origins. Below Header states that Our Rest Api is Accessed By Anyone.
    header("Access-Control-Allow-Origin: *");

    // Json Decode convert incomming json data to object by default but when we add second parameter true. It will be convert incoming json data to php associative array.
    $data = json_decode(file_get_contents("php://input"), true);

    // When The Sending JSON by Client is Not Valid JSON
    if (!$data) {
        goto label;
    }

    // Connection With Database
    include_once "config.php";

    // Sql Query For fetching single record from database
    $sql = "SELECT * FROM person WHERE ID = {$data['id']}";

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
    else {
        label:
        echo json_encode(array("message" => "Your Sending POST Data is Not Valid JSON!", "status" => false), JSON_PRETTY_PRINT);
    }
?>

