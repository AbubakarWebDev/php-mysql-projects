<?php

// ** MySQL settings - You can get this info from your web host ** //

/** The name of the database for WordPress */
define( 'DB_NAME', 'rest-crud-application');

/** MySQL database username */
define( 'DB_USER', 'root');

/** MySQL database password */
define( 'DB_PASSWORD', '');

/** MySQL hostname */
define( 'DB_HOST', 'localhost');

/** Website hostname */
$hostname = "https://localhost/php-ajax/rest-crud-application";

/** Establishing Connection With MySQL */
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die(json_encode(array("error" => "Connection Failed", "message" => mysqli_connect_error(), "status" => false), JSON_PRETTY_PRINT));

?>