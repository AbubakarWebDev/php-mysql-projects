<?php
    function delete_file($file) 
    {
        $file = urldecode($file); // Decode URL-encoded string
        $filepath = "uploads/$file";
        if(!file_exists($filepath)) {
            array("message" => "File not found or inaccessible!", "status" => "false");
        }
        else {
            unlink($filepath);
            return array("message" => "File is Deleted Successfully", "status" => "true");

        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") 
    { 
        echo json_encode(delete_file($_POST["file"]));
    }

?>