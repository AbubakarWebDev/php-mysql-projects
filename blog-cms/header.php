<!doctype html>
<html lang="en">

<head>

    <?php

        include_once "admin/config.php";    
        
        $title = "";

        switch (basename($_SERVER["PHP_SELF"])) 
        {
            case 'index.php':
                $title = "Tech Memorise: Learn Web Development SEO & Tech Tutorials";
                break;

            case 'author.php':

                $sql = "SELECT * FROM users WHERE user_id = {$author_id}";

                if ($result = mysqli_query($connection, $sql)) 
                {
                    if(mysqli_num_rows($result) > 0) 
                    {
                        $row = mysqli_fetch_array($result);
                        $title = "Post By {$row["username"]} - Tech Memorise";
                    }
                    else {
                        $title = "Tech Memorise: Learn Web Development SEO & Tech Tutorials";
                    }
                }
                else {
                    echo "<script>alert('Query Unsuccessfull')</script>";
                }

                break;

            case 'category.php':
                
                $sql = "SELECT * FROM category WHERE category_id = {$category_id}";

                if ($result = mysqli_query($connection, $sql)) 
                {
                    if(mysqli_num_rows($result) > 0) 
                    {
                        $row = mysqli_fetch_array($result);
                        $title = "{$row["category_name"]} - Tech Memorise";
                    }
                    else {
                        $title = "Tech Memorise: Learn Web Development SEO & Tech Tutorials";
                    }
                }
                else {
                    echo "<script>alert('Query Unsuccessfull')</script>";
                }

                break;

            case 'post.php':
                $sql = "SELECT * FROM post WHERE post_id = {$post_id}";

                if ($result = mysqli_query($connection, $sql))
                {
                    if(mysqli_num_rows($result) > 0) 
                    {
                        $row = mysqli_fetch_array($result);
                        $title = "{$row["post_title"]} - Tech Memorise";
                    }
                    else {
                        $title = "Tech Memorise: Learn Web Development SEO & Tech Tutorials";
                    }
                }
                else {
                    echo "<script>alert('Query Unsuccessfull')</script>";
                }
                break;

            case 'search.php':
                if(!empty($search)) 
                {
                    $title = "$search - Techmemorise";
                }
                else {
                    $title = "Tech Memorise: Learn Web Development SEO & Tech Tutorials";
                }
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

<!-- Upper Navigation -->
<div class="upper-navbar d-flex justify-content-between">
        <div class="d-flex">
            <a class="nav-item nav-link" href="<?php echo $hostname ?>blog-cms">Home</a>
            <a class="nav-item nav-link" href="#">About us</a>
            <a class="nav-item nav-link" href="#">Contact us</a>
        </div>
        <div class="d-flex">
            <a class="nav-item nav-link" href="#"><i class="fab fa-youtube"></i></a>
            <a class="nav-item nav-link" href="#"><i class="fab fa-facebook-square"></i></a>
            <a class="nav-item nav-link" href="#"><i class="fab fa-twitter"></i></a>
            <a class="nav-item nav-link" href="#"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
</div>

<!-- Header Logo Area -->
<div class="header my-5">
    <div class="outer">
        <div class="column mx-4">
            <a href="<?php echo $hostname ?>blog-cms">
                <img class="img-fluid" src="images/logo.png" alt="image" />
            </a>
        </div>
        <div class="column mx-4">
            <a href="#">
                <img class="img-fluid" src="images/header-ad.gif" alt="image" />
            </a>
        </div>
    </div>
</div>

<!-- Navigation Bar -->
<nav id="navbar" class="navbar navbar-expand-lg navbar-dark sticky-top p-0">
    <button class="navbar-toggler ml-4" type="button" data-toggle="collapse" data-target="#NavbarContent">
        <span class=""><i class="fas fa-bars"></i></span>
    </button>
    <div id="search-open" class="nav-search">
        <i class="fas fa-search"></i>
    </div>
    <div class="collapse navbar-collapse" id="NavbarContent">
        <div class="navbar-nav text-center ml-0 ml-md-3 mr-auto">
            <a class="nav-item nav-link" href="<?php echo $hostname ?>blog-cms"><i class="fas fa-home"></i>&nbsp; Home</a>

            <?php

                $sql = "SELECT * FROM category WHERE no_of_post > 0 LIMIT 5";

                if ($result = mysqli_query($connection, $sql)) 
                {
                    if(mysqli_num_rows($result) > 0) 
                    {
                        while($row = mysqli_fetch_array($result)) 
                        {
                            echo "
                            <a class='nav-item nav-link' href='category.php?category_id={$row['category_id']}'>{$row['category_name']}</a>";
                        }
                    }
                }
                else {
                    echo "<script>alert('Query Unsuccessfull')</script>";
                }
            ?>
        </div>
    </div>
</nav>