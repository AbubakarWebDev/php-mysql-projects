<?php

    function validateFile(&$file, $fileMaxAllowedSize, $fileAllowedExtensions, $fileUploadDir, &$message) {
        $uploadedFiles = [];
        // Check if the Multiple File is Uploaded
        if (is_array($file["name"]))
        {
            // Loop for Validating All files one by one
            for ($i=0; $i < count($file["name"]); $i++)
            { 
                // All File Variables For Validation
                $filename = htmlspecialchars(pathinfo($file["name"][$i], PATHINFO_BASENAME));
                $filetype = $file["type"][$i];
                $filesize = $file["size"][$i];
                $fileTmpName = $file["tmp_name"][$i];
                $fileError = $file["error"][$i];
                $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

                // Check if file was uploaded without errors
                if(isset($file) && ($fileError == 0)) 
                {
                    // Verify file extension
                    if(!array_key_exists($fileExtension, $fileAllowedExtensions)) {
                        $message = "Error: Please select a valid file format.";
                        break;
                    }
                    else {
                        // Verify file size - 5MB maximum
                        if ($filesize > $fileMaxAllowedSize) {
                            $message = "Error: File size is larger than the allowed limit.";
                            break;
                        }
                        else 
                        {
                            // Verify MYME type of the file
                            if (in_array($filetype, $fileAllowedExtensions)){
                                // Check whether file exists before uploading it
                                if (file_exists("$fileUploadDir/$filename")){
                                    // echo $filename . " is already exists.";
                                }
                                
                                move_uploaded_file($fileTmpName, "$fileUploadDir/$filename");

                                $uploadedFiles[$i] = "$fileUploadDir/$filename";
                            }
                            else {
                                $message = "Error: There was a problem uploading your file. Please try again.";
                                break;
                            }
                        }
                    }
                }
                else 
                {   
                    // check if when user press upload button without selecting files
                    if ($filename == "" && $filesize == 0) {
                        $message = "Error: No File is Selected For Upload.";
                        break;
                    }
                    // Check if file was uploaded with errors
                    else {
                        $message = "Error: $fileError";
                        break;
                    }
                }
            }
        }
        else 
        {
            // All File Variables For Validation
            $filename = htmlspecialchars(pathinfo($file["name"], PATHINFO_BASENAME));
            $filetype = $file["type"];
            $filesize = $file["size"];
            $fileTmpName = $file["tmp_name"];
            $fileError = $file["error"];
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

            // Check if file was uploaded without errors
            if(isset($file) && ($fileError == 0)) 
            {
                // Verify file extension
                if(!array_key_exists($fileExtension, $fileAllowedExtensions)) {
                    $message = "Error: Please select a valid file format.";
                }
                else {
                    // Verify file size - 5MB maximum
                    if ($filesize > $fileMaxAllowedSize) {
                        $message = "Error: File size is larger than the allowed limit.";
                    }
                    else {
                        // Verify MYME type of the file
                        if (in_array($filetype, $fileAllowedExtensions)) {
                            // Check whether file exists before uploading it
                            if (file_exists("$fileUploadDir/$filename")) {
                                // echo $filename . " is already exists.";
                            }

                            move_uploaded_file($fileTmpName, "$fileUploadDir/$filename");
                            $uploadedFiles = "$fileUploadDir/$filename";
                        }
                        else {
                            $message = "Error: There was a problem uploading your file. Please try again.";
                        }
                    }
                }
            }
            else {
                if ($filename == "" && $filesize == 0) {
                    $message = "Error: No File is Selected For Upload.";
                }
                else {
                    $message = "Error: $fileError";
                }
            }
        }
        
        $message = (strlen($message) == 0)? $message : "<b class='text-danger'>" . $message . "</b>";
        return $uploadedFiles;
    } 
?>