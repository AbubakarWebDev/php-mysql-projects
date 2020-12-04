<?php

    session_start();

    session_unset("username");
    session_unset("message");

    setcookie("emailCookie", '', time() - 86400);
    setcookie("passwordCookie", '', time() - 86400);

    session_destroy();

    header("Location: login.php");

?>