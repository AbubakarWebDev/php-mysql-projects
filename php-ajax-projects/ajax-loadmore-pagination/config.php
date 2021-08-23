<?php
    // ** MySQL settings - You can get this info from your web host ** //

    /** The name of the database for WordPress */
    define( 'DB_NAME', 'ajax-loadmore-application');

    /** MySQL database username */
    define( 'DB_USER', 'root');

    /** MySQL database password */
    define( 'DB_PASSWORD', '');

    /** MySQL hostname */
    define( 'DB_HOST', 'localhost');

    /** Establishing Connection With MySQL */
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Connection Failed" . mysqli_connect_error());
?>