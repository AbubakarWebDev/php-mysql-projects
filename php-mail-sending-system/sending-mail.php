<?php
    session_start();

    function convert_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function in_array_all($find, $array){      
        foreach($array as $key => $value){
          if($value != $find){
            return false;
          }
        }
        return true;
    }

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

        include "upload.php";
        $file = $_FILES["files"];
        $file_allowed_extensions = [
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
        $file_maximum_allowed_size = 5 * 1024 * 1024;   // 5 MB 
        $file_upload_directory_name = "uploads";

        $data["files"] = validateFile($file, $file_maximum_allowed_size, $file_allowed_extensions, $file_upload_directory_name, $dataError["filesError"]); 
        
        $dataError["filesError"] = ($dataError["filesError"] == "<b class='text-danger'>Error: No File is Selected For Upload.</b>")? "": $dataError["filesError"];

        if (in_array_all("" , $dataError)) {

            include "mail.php";
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

