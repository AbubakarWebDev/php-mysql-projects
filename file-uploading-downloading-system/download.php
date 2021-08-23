<?php
    /*function to set your files*/
    function output_file($file)
    {
        $file = urldecode($file); // Decode URL-encoded string
        $filepath = "uploads/$file";
        if(!file_exists($filepath)) die('File not found or inaccessible!');
        $size = filesize($filepath);
        
        $known_mime_types = [
            "jpg" => "image/jpg",
            "jpeg"=> "image/jpeg",
            "png" => "image/png",
            "gif" => "image/gif",
            "doc" => "application/msword",
            "pdf" => "application/pdf",
            "ppt" => "application/vnd.ms-powerpoint",
            "xls" => "application/vnd.ms-excel",
            "txt" => "text/plain",
            "htm" => "text/html",
            "html"=> "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            "php" => "text/plain"
        ];

        /* Check MIME Type of The File */
        $file_extension = pathinfo($file, PATHINFO_EXTENSION);
        if(array_key_exists($file_extension, $known_mime_types)){
            $mime_type = $known_mime_types[$file_extension];
        } 
        else {
            $mime_type = "application/force-download";
        };

        header('Content-Description: File Transfer');
        header('Content-Type: application/' . $mime_type);
        header('Content-Disposition: attachment; filename="' .$file. '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . $size);
        flush(); // Flush system output buffer
        readfile($filepath);
        exit();
    }

    if(isset($_GET["file"])) {
        /*output must be folder/yourfile*/
        output_file($_GET["file"]);
        /*back to index.php while downloading*/
        header('Location: index.php');
    }
?>