<?php

    function validateFile(&$file, $fileMaxAllowedSize, $fileAllowedExtensions, $fileUploadDir, &$error_message)
    {
        // empty array creating for uploaded file
        $uploadedFiles = [""];

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
                        $error_message = "Error: Please select a valid file format.";
                        break;
                    }
                    else {
                        // Verify file size - 5MB maximum
                        if ($filesize > $fileMaxAllowedSize) {
                            $error_message = "Error: File size is larger than the allowed limit.";
                            break;
                        }
                        else 
                        {
                            // Verify MYME type of the file
                            if (in_array($filetype, $fileAllowedExtensions))
                            {
                                // Appending Unique time String With the name of file
                                $filename = str_replace(".$fileExtension", "-" .time(). ".$fileExtension",$filename);

                                // Check whether file exists before uploading it
                                if (file_exists("$fileUploadDir/$filename"))
                                {
                                    // Appending Unique time String With the name of file If file is Already Exist
                                    $filename = str_replace(".$fileExtension", "-" .time(). ".$fileExtension",$filename);
                                }
                                
                                move_uploaded_file($fileTmpName, "$fileUploadDir/$filename");
                                $uploadedFiles[$i] = "$filename";
                            }
                            else {
                                $error_message = "Error: There was a problem uploading your file. Please try again.";
                                break;
                            }
                        }
                    }
                }
                else 
                {   
                    // check if when user press upload button without selecting files
                    if ($filename == "" && $filesize == 0) {
                        $error_message = "Error: No File is Selected For Upload.";
                        break;
                    }
                    // Check if file was uploaded with errors
                    else {
                        $error_message = "Error: $fileError";
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
                    $error_message = "Error: Please select a valid file format.";
                }
                else {
                    // Verify file size - 5MB maximum
                    if ($filesize > $fileMaxAllowedSize) {
                        $error_message = "Error: File size is larger than the allowed limit.";
                    }
                    else {
                        // Verify MYME type of the file
                        if (in_array($filetype, $fileAllowedExtensions)) {

                            // Appending Unique time String With the name of file
                            $filename = str_replace(".$fileExtension", "-" .time(). ".$fileExtension",$filename);

                            // Check whether file exists before uploading it
                            if (file_exists("$fileUploadDir/$filename")) 
                            {
                                // Appending Unique time String With the name of file If file is Already Exist
                                $filename = str_replace(".$fileExtension", "-" .time(). ".$fileExtension",$filename);
                            }

                            move_uploaded_file($fileTmpName, "$fileUploadDir/$filename");
                            $uploadedFiles[0] = "$filename";
                        }
                        else {
                            $error_message = "Error: There was a problem uploading your file. Please try again.";
                        }
                    }
                }
            }
            else {
                if ($filename == "" && $filesize == 0) {
                    $error_message = "Error: No File is Selected For Upload.";
                }
                else {
                    $error_message = "Error: $fileError";
                }
            }
        }
        
        $error_message = (strlen($error_message) == 0)? $error_message : "<b class='text-danger'>" . $error_message . "</b>";
        return $uploadedFiles;
    }

?>