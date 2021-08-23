<?php
    session_start();

    include_once "config.php";

    if (!isset($_SESSION["user"]) && !(basename($_SERVER["PHP_SELF"]) == "index.php") && !(basename($_SERVER["PHP_SELF"]) == "forgot-password.php") && !(basename($_SERVER["PHP_SELF"]) == "reset-password.php")) {
        header("Location: index.php");
    }

    function string_contains($str, $find) 
    {
        if(strpos("$str", "$find") !== false) 
        {
            return true;
        }
        else {
            return false;
        }
    }
?>

<!doctype html>
<html lang="en">

<head>
    
    <?php

        $title = "";

        switch (basename($_SERVER["PHP_SELF"])) 
        {
            case 'index.php':
                $title = "Login Panel - Tech Memorise";
                break;

            case 'forgot-password.php':
                $title = "Forgot Password - Tech Memorise";
                break;

            case 'reset-password.php':
                $title = "Reset Password - Tech Memorise";
                break;

            case 'category.php':
                $title = "All Categories - Tech Memorise";
                break;

            case 'category-edit.php':
                $title = "Edit Category - Tech Memorise";
                break;

            case 'add-category.php':
                $title = "Add New Category - Tech Memorise";
                break;

            case 'post.php':
                $title = "All Posts - Tech Memorise";
                break;

            case 'post-edit.php':
                $title = "Edit post - Tech Memorise";
                break;

            case 'add-post.php':
                $title = "Add New post - Tech Memorise";
                break;

            case 'users.php':
                $title = "All users - Tech Memorise";
                break;

            case 'user-edit.php':
                $title = "Edit user - Tech Memorise";
                break;

            case 'add-user.php':
                $title = "Add New user - Tech Memorise";
                break;
            
            default:
                $title = "Tech Memorise: Learn Web Development SEO & Tech Tutorials";
                break;
        }

        $title = ucwords($title);

        echo "<!-- Page Title -->
        <title>$title</title>";
    ?>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Orbitron|Anton|Cabin|Lato|Fjalla+One|Montserrat|Roboto&display=swap" rel="stylesheet">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha2/css/bootstrap.min.css">

    <!-- Custom CSS  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
<?php
    if (!(basename($_SERVER["PHP_SELF"]) == "index.php") && !(basename($_SERVER["PHP_SELF"]) == "forgot-password.php") && !(basename($_SERVER["PHP_SELF"]) == "reset-password.php")) 
    {
        echo
        "<!-- Navigation Bar -->
        <nav id='navbar' class='navbar navbar-expand-lg navbar-dark sticky-top p-0'>
            
            <a class='navbar-brand ml-2' href='{$hostname}blog-cms' target='_blank'>
                <img src='images/techmemorise.png' alt='Site Logo'>
            </a>
            
            <button class='navbar-toggler ml-4' type='button' data-toggle='collapse' data-target='#NavbarContent'>
                <span><i class='fas fa-bars'></i></span>
            </button>
            
            <div class='user-name order-lg-1 order-0 text-center'>
                <span>Hello {$_SESSION['user']['username']} </span>
                <a href='logout.php'>Logout</a>
            </div>
            
            <div class='collapse navbar-collapse justify-content-center' id='NavbarContent'>
                <div class='navbar-nav text-center'>
                    <a class='nav-item nav-link' href='post.php'>Post</a>";
                
                    if ($_SESSION['user']['user_role'] == 'admin') 
                    {
                        echo "<a class='nav-item nav-link' href='category.php'>Categories</a>
                        <a class='nav-item nav-link' href='users.php'>Users</a>";
                    }

                echo"
                </div>
            </div>
        </nav>";
    }
?>