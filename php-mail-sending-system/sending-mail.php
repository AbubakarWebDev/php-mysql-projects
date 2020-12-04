<?php
    function convert_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validateFile($inputFileName, $totalFiles, $fileMaxAllowedSize, $fileAllowedExtensions, $fileUploadDir, &$message) {
        // Check if the Total uploaded Files is greater than one
        if (is_array($_FILES[$inputFileName]["name"])) {
            // Loop for Validating All files one by one
            for ($i=0; $i < $totalFiles; $i++) { 
                
                // All File Variables For Validation
                $file = $_FILES[$inputFileName];
                $filename = htmlspecialchars(basename($_FILES[$inputFileName]["name"][$i]));
                $filetype = $_FILES[$inputFileName]["type"][$i];
                $filesize = $_FILES[$inputFileName]["size"][$i];
                $fileTmpName = $_FILES[$inputFileName]["tmp_name"][$i];
                $fileError = $_FILES[$inputFileName]["error"][$i];
                $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

                // Check if file was uploaded without errors
                if(isset($file) && ($fileError == 0)) {
                    // Verify file extension
                    if(!array_key_exists($fileExtension, $fileAllowedExtensions)) {
                        $message["error"] = "<b class='text-danger'>Error: Please select a valid file format.</b>";
                        break;
                    }
                    else {
                        // Verify file size - 5MB maximum
                        if ($filesize > $fileMaxAllowedSize) {
                            $message["error"] = "<b class='text-danger'>Error: File size is larger than the allowed limit.</b>";
                            break;
                        }
                        else {
                            // Verify MYME type of the file
                            if (in_array($filetype, $fileAllowedExtensions)){
                                // Check whether file exists before uploading it
                                if (file_exists($fileUploadDir . $filename)){
                                    // echo $filename . " is already exists.";
                                }
                                
                                move_uploaded_file($fileTmpName, $fileUploadDir . $filename);
                                $message["uploadedFiles"][$i] = $fileUploadDir . $filename;
                            }
                            else {
                                $message["error"] = "<b class='text-danger'>Error: There was a problem uploading your file. Please try again.</b>";
                                break;
                            }
                        }
                    }
                }
                else {
                    if ($filename == "" && $filesize == 0) {
                        $message["error"] = "<b class='text-danger'>Error: No File is Selected For Upload.</b>";
                        break;
                    }
                    else {
                        $message["error"] = "<b class='text-danger'>Error: $fileError </b>";
                        break;
                    }
                }
            }
        }
        else {
            // All File Variables For Validation
            $file = $_FILES[$inputFileName];
            $filename = htmlspecialchars(basename($_FILES[$inputFileName]["name"]));
            $filetype = $_FILES[$inputFileName]["type"];
            $filesize = $_FILES[$inputFileName]["size"];
            $fileTmpName = $_FILES[$inputFileName]["tmp_name"];
            $fileError = $_FILES[$inputFileName]["error"];
            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

            // Check if file was uploaded without errors
            if(isset($file) && ($fileError == 0)) {
                // Verify file extension
                if(!array_key_exists($fileExtension, $fileAllowedExtensions)) {
                    $message["error"] = "<b class='text-danger'>Error: Please select a valid file format.</b>";
                }
                else {
                    // Verify file size - 5MB maximum
                    if ($filesize > $fileMaxAllowedSize) {
                        $message["error"] = "<b class='text-danger'>Error: File size is larger than the allowed limit.</b>";
                    }
                    else {
                        // Verify MYME type of the file
                        if (in_array($filetype, $fileAllowedExtensions)){
                            // Check whether file exists before uploading it
                            if (file_exists($fileUploadDir . $filename)){
                                // echo $filename . " is already exists.";
                            }
                            
                            move_uploaded_file($fileTmpName, $fileUploadDir . $filename);
                            $message["uploadedFiles"][0] = $fileUploadDir . $filename;
                        }
                        else {
                            $message["error"] = "<b class='text-danger'>Error: There was a problem uploading your file. Please try again.</b>";
                        }
                    }
                }
            }
            else {
                if ($filename == "" && $filesize == 0) {
                    $message["error"] = "<b class='text-danger'>Error: No File is Selected For Upload.</b>";
                }
                else {
                    $message["error"] = "<b class='text-danger'>Error: $fileError </b>";
                }
            }
        }
    }

    function in_array_all($find,$array){      
        foreach($array as $key => $value){
          if($value != $find){
            return false;
          }
        }
        return true;
    }

    include "mail.php";

    $data = [
        "receipientEmail" => "",
        "senderName" => "",
        "senderEmail" => "",
        "emailSubject" => "",
        "emailBody" => "",
        "files" => []
    ];

    $dataError = [
        "receipientEmailError" => "",
        "senderNameError" => "",
        "senderEmailError" => "",
        "emailSubjectError" => "",
        "emailTypeError" => "",
        "emailBodyError" => "",
        "filesError" => ""
    ];
    
    if (isset($_POST["submit"])) {
        
        if (empty($_POST["receipientEmail"])) {
            $dataError["receipientEmailError"] = "<b class='text-danger'>* Email is Required</b>";
        }
        else {
            $data["receipientEmail"] = convert_input($_POST["receipientEmail"]);
            
            if (!filter_var($data["receipientEmail"], FILTER_VALIDATE_EMAIL)) {
                $dataError["receipientEmailError"] = "<b class='text-danger'> Invalid email format</b>";
            }
        }
        
        if (empty($_POST["senderName"])) {
            $dataError["senderNameError"] = "<b class='text-danger'>* Name is Required</b>";
        }
        else {
            $data["senderName"] = convert_input($_POST["senderName"]);
            
            if (!preg_match("/^[^ ][a-zA-Z ]{3,}$/",$data["senderName"])) {
                $dataError["senderNameError"] = "<b class='text-danger'>At Least 3 Letters and WhiteSpaces Allowed</b>";;
            }
        }
        
        if (empty($_POST["senderEmail"])) {
            $dataError["senderEmailError"] = "<b class='text-danger'>* Email is Required</b>";
        }
        else {
            $data["senderEmail"] = convert_input($_POST["senderEmail"]);
            
            if (!filter_var($data["senderEmail"], FILTER_VALIDATE_EMAIL)) {
                $dataError["senderEmailError"] = "<b class='text-danger'> Invalid email format</b>";
            }
        }

        if (empty($_POST["emailSubject"])) {
            $dataError["emailSubjectError"] = "<b class='text-danger'>* Email Subject is Required</b>";
        }
        else {
            $data["emailSubject"] = convert_input($_POST["emailSubject"]);
            
            if (!preg_match("/^[^ ][a-zA-Z. ]{3,}$/",$data["emailSubject"])) {
                $dataError["emailSubjectError"] = "<b class='text-danger'>At Least 3 Letters and WhiteSpaces Allowed</b>";
            }
        }
        
        if (empty($_POST["emailBody"])) {
            $dataError["emailBodyError"] = "<b class='text-danger'>* Email Message is Required</b>";
        }
        else {
            $data["emailBody"] = convert_input($_POST["emailBody"]);
            
            if (!preg_match("/^[^ ][a-zA-Z. ]{3,}$/",$data["emailBody"])) {
                $dataError["emailBodyError"] = "<b class='text-danger'>At Least 3 Letters and WhiteSpaces Allowed</b>";
            }
        }
        
        $allowedExtensions = [
            "jpg" => "image/jpg",
            "jpeg"=> "image/jpeg",
            "png" => "image/png",
            "gif" => "image/gif",
            "doc" => "application/msword",
            "pdf" => "application/pdf",
            "ppt" => "application/vnd.ms-powerpoint",
            "xls" => "application/vnd.ms-excel",
            "txt" => "text/plain"
        ];
        
        if (is_array($_FILES["files"]["name"])) {
            $total = count($_FILES["files"]["name"]);
        }
        else {
            $total = 1;
        }
        
        $fileMessage = ["error" => "", "uploadedFiles" => []];
        validateFile("files", $total, 10 * 1024 * 1024, $allowedExtensions, "uploads/", $fileMessage);
        
        if ($fileMessage["error"] == "") {
            $data["files"] = $fileMessage["uploadedFiles"];
        }
        else {
            $dataError["filesError"] = $fileMessage["error"];
        }

        session_start();
        
        if (in_array_all("" , $dataError)) {
            $mail = false;

            if (empty($data["files"])) {
                $mail = send_mail($data["receipientEmail"], $data["emailSubject"], $data["emailBody"], $data["senderName"], $data["senderEmail"]);
            }
            else {
                $mail = send_multi_attach_mail($data["receipientEmail"], $data["emailSubject"], $data["emailBody"], $data["senderName"], $data["senderEmail"], $data["files"]);
            }
    
            if ($mail) {
                $_SESSION["ALL_DATA"] = ["data" => $data , "dataError" => $dataError, "email" => "OK"];
            }
            else {
                $_SESSION["ALL_DATA"] = ["data" => $data , "dataError" => $dataError, "email" => ""];
            }
            header("Location: index.php");
        }
        else {
            $_SESSION["ALL_DATA"] = ["data" => $data , "dataError" => $dataError, "email" => ""];
            header("Location: index.php");
        }

        
    }
?>

