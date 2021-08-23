<?php
    function returnUploadedFiles($path = "uploads")
    {
        $all_uploaded_files = [];

        // Check directory exists or not
        if(file_exists($path) && is_dir($path)) 
        {
            // Scan the files in this directory
            $result = scandir($path);
            
            // Filter out the current (.) and parent (..) directories
            $files = array_diff($result, array('.', '..'));

            if(count($files) > 0)
            {
                // Loop through array to create image gallery
                foreach($files as $file) 
                {
                    array_push($all_uploaded_files, array("file" => $file));
                }

                $all_uploaded_files["status"] = true;
            }
            else {
                $all_uploaded_files["status"] = false;
                $all_uploaded_files["errorMessage"] = "No Files Are Present On Directory!";
            }
        } 
        else {
            $all_uploaded_files["status"] = false;
            $all_uploaded_files["errorMessage"] = "ERROR: The Upload directory does not Exist";
        }

        return $all_uploaded_files;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") { 
        echo json_encode(returnUploadedFiles("uploads"));
    }

?>