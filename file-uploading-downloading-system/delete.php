<?php

function delete_file($file) {
    $file = urldecode($file); // Decode URL-encoded string
    $filepath = "uploads/$file";
    if(!file_exists($filepath)) die('File not found or inaccessible!');
    unlink($filepath);
}

if(isset($_GET["file"])) 
{
    /*output must be folder/yourfile*/
    delete_file($_GET["file"]);
    /*back to index.php while downloading*/
    header('Location: index.php');
}

?>