<?php session_start(); echo (isset($_SESSION["username"]))? "" : "<script>location.href='login.php'</script>"?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Registration System - Main Page</title>

    <?php include "links.php"; ?>
</head>

<style>
    html {
        scroll-behavior: smooth;
    }

    .nav-item {
        position: relative;
        font-weight: bolder;
        text-align: center;
        font-size: 25px;
        text-transform: uppercase;
        transition: 0.4s linear;
    }

    .navbar-dark .navbar-nav .nav-link {
        color: #fff;
    }

    .navbar-light .navbar-nav .nav-link {
        color: black;
    }

    .nav-item:hover {
        color: rgb(255, 188, 2) !important;
        text-shadow: 3px 2px 5px #000;
    }

    .logo {
        position: relative;
        font-weight: bolder;
        font-size: 35px;
        transition: 0.4s linear;
    }

    .navbar-dark .logo {
        color: white;
    }

    .navbar-light .logo {
        color: black;
    }

    .logo:hover {
        color: rgb(255, 188, 2) !important;
        text-shadow: 3px 2px 5px #000;
    }

    .navbar-dark .navbar-toggler {
        border: 1px solid white;
        color: white;
    }

    .navbar-light .navbar-toggler {
        border: 1px solid black;
        color: black;
    }

    .navbar {
        transition: 0.4s linear;
    }

    .master-head {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: auto 0;
        font-family: "Roboto", sans-serif;
    }

    .master-head h3 {
        text-align: center;
        font-size: 20px;
        color: white;
        margin: 20px 0px;
    }

    .master-head h1 {
        text-align: center;
        font-size: 70px;
        color: white;
    }

    .master-head .btn-section {
        display: flex;
        margin-top: 10px;
        text-align: center;
        justify-content: center;
    }

    .master-head button {
        width: 140px;
        height: 45px;
        font-size: 14px;
        font-weight: bold;
        outline: none;
        transition: 0.4s linear;
    }

    .master-head button:first-child {
        background-color: white;
        color: black;
        border: none;
    }

    .master-head button:first-child:hover {
        background-color: rgba(243, 182, 59);
    }

    .master-head button:last-child {
        margin-left: 5px;
        background-color: transparent;
        color: white;
        border: 3px solid white;
    }

    .master-head button:last-child:hover {
        color: black;
        background-color: rgba(243, 182, 59);
        border: none;
    }

    .master-head {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(bg.jpg);
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center center;
        background-size: cover;
        height: 90vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .services-container {
        margin-top: 130px;
        margin-bottom: 100px;
    }

    .section-title {
        font-size: 50px;
    }

    .subtitle {
        font-size: 18px;
        margin-bottom: 70px;
    }

    .shadow,
    .subscription-wrapper {
        box-shadow: 0px 15px 39px 0px rgba(8, 18, 109, 0.1) !important
    }

    .icon-primary {
        color: #062caf
    }

    .icon-bg-circle {
        position: relative
    }

    .icon-lg {
        font-size: 50px
    }

    .icon-bg-circle::before {
        z-index: 1;
        position: relative
    }

    .icon-bg-primary::after {
        background: #062caf !important
    }

    .icon-bg-circle::after {
        content: '';
        position: absolute;
        width: 68px;
        height: 68px;
        top: -35px;
        left: 15px;
        border-radius: 50%;
        background: inherit;
        opacity: .1
    }

    p,
    .paragraph {
        font-weight: 400;
        color: #8b8e93;
        font-size: 15px;
        line-height: 1.6;
        font-family: "Open Sans", sans-serif
    }

    .icon-bg-yellow::after {
        background: #f6a622 !important
    }

    .icon-bg-purple::after {
        background: #7952f5
    }

    .icon-yellow {
        color: #f6a622
    }

    .icon-purple {
        color: #7952f5
    }

    .icon-cyan {
        color: #02d0a1
    }

    .icon-bg-cyan::after {
        background: #02d0a1
    }

    .icon-bg-red::after {
        background: #ff4949
    }

    .icon-red {
        color: #ff4949
    }

    .icon-bg-green::after {
        background: #66cc33
    }

    .icon-green {
        color: #66cc33
    }

    .icon-bg-orange::after {
        background: #ff7c17
    }

    .icon-orange {
        color: #ff7c17
    }

    .icon-bg-blue::after {
        background: #3682ff
    }

    .icon-blue {
        color: #3682ff
    }

    .font-20 {
        font-size: 20px;
    }
</style>

<body>

    <!-- Navigation Bar -->
    <nav id="navbar" class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
        <a class="navbar-brand ml-3 logo" href="">WEB DEV</a>
        <button class="navbar-toggler mr-3 py-2" type="button" data-toggle="collapse" data-target="#NavbarContent">
            <span class="">MENU <i class="fas fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="NavbarContent">
            <div class="navbar-nav ml-md-auto ml-3 mr-3">
                <a class="nav-item nav-link" href="">Home</a>
                <a class="nav-item nav-link" href="#services">Services</a>
                <a class="nav-item nav-link" href="#">About</a>
                <a class="nav-item nav-link" href="#">Contact</a>
                <a class="mt-1 mb-md-0 mb-3 text-center" href="logout.php">
                    <button class="btn btn-primary font-weight-bolder ml-md-3 text-uppercase font-20">Logout</button>
                </a>
            </div>
        </div>
    </nav>

    <!-- Master Header -->
    <div class="master-head">
        <div class="head-container">
            <h3> DESIGN &#9898; DEVELOPMENT &#9898; BRANDING </h3>
            <h1 class="text-uppercase"> WELCOME <?php echo $_SESSION["username"] ?></h1>
            <h3> WE ARE THE ONE OF THE WORLD'S TOP CREATIVE DESIGN AGENCIES </h3>
            <div class="btn-section">
                <button>READ MORE</button>
                <button>SUBSCRIBE</button>
            </div>
        </div>
    </div>

    <!-- Our Services Section -->
    <div id="services" class="container services-container ">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-title">Our Services</h2>
                <p class="subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam, fuga.</p>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card border-0 shadow rounded-xs pt-5">
                    <div class="card-body"> 
                        <i class="fa fa-object-ungroup icon-lg icon-primary icon-bg-primary icon-bg-circle mb-3"></i>
                        <h4 class="mt-4 mb-3">Networking</h4>
                        <p>For what reason would it be advisable for me to think about business content?</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card border-0 shadow rounded-xs pt-5">
                    <div class="card-body"> 
                        <i class="fa fa-users icon-lg icon-yellow icon-bg-yellow icon-bg-circle mb-3"></i>
                        <h4 class="mt-4 mb-3">Social Activity</h4>
                        <p>For what reason would it be advisable for me to think about business content?</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card border-0 shadow rounded-xs pt-5">
                    <div class="card-body"> 
                        <i class="fa fa-desktop icon-lg icon-purple icon-bg-purple icon-bg-circle mb-3"></i>
                        <h4 class="mt-4 mb-3">Web Design</h4>
                        <p>For what reason would it be advisable for me to think about business content?</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card border-0 shadow rounded-xs pt-5">
                    <div class="card-body"> 
                        <i class="fa fa-cloud icon-lg icon-cyan icon-bg-cyan icon-bg-circle mb-3"></i>
                        <h4 class="mt-4 mb-3">Cloud Service</h4>
                        <p>For what reason would it be advisable for me to think about business content?</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card border-0 shadow rounded-xs pt-5">
                    <div class="card-body">
                        <i class="fa fa-comments icon-lg icon-red icon-bg-red icon-bg-circle mb-3"></i>
                        <h4 class="mt-4 mb-3">Consulting</h4>
                        <p>For what reason would it be advisable for me to think about business content?</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card border-0 shadow rounded-xs pt-5">
                    <div class="card-body"> 
                        <i class="fa fa-search-plus icon-lg icon-green icon-bg-green icon-bg-circle mb-3"></i>
                        <h4 class="mt-4 mb-3">SEO Optimization</h4>
                        <p>For what reason would it be advisable for me to think about business content?</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card border-0 shadow rounded-xs pt-5">
                    <div class="card-body">
                        <i class="fa fa-user icon-lg icon-orange icon-bg-orange icon-bg-circle mb-3"></i>
                        <h4 class="mt-4 mb-3">Usability Testing</h4>
                        <p>For what reason would it be advisable for me to think about business content?</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card border-0 shadow rounded-xs pt-5">
                    <div class="card-body">
                        <i class="fa fa-envelope icon-lg icon-blue icon-bg-blue icon-bg-circle mb-3"></i>
                        <h4 class="mt-4 mb-3">UX Prototyping</h4>
                        <p>For what reason would it be advisable for me to think about business content?</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "scripts.php"; ?>

    <script>
        $("document").ready(function () {
            $(window).scroll(function () {
                let headerSize = $("#navbar").css("height");
                if ($(window).scrollTop() > headerSize.slice(0, headerSize.indexOf("px"))) {
                    $("#navbar").removeClass("navbar-dark bg-dark");
                    $("#navbar").addClass("navbar-light bg-light shadow-lg");
                }
                else {
                    $("#navbar").removeClass("navbar-light bg-light shadow-lg");
                    $("#navbar").addClass("navbar-dark bg-dark");
                }
            });
        });
    </script>
</body>

</html>