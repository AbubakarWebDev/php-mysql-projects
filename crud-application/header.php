<style>
    .nav-item {
        position: relative;
        font-weight: bolder;
        text-align: center;
        font-size: 25px;
        color: #fff !important;
        text-transform: uppercase;
        transition: 0.4s ease;
    }

    .nav-item::before, .nav-item::after{
        content: "";
        position: absolute;
        width: 0;
        height: 3px;
        border-radius: 5px;
        background-color: #fff;
        transition: 0.4s ease;
    }

    .nav-item::after {
        right: 0;
        top: 6px;
    }

    .nav-item::before {
        left: 0;
        bottom: 7px;
    }

    .nav-item:hover {
        color: rgb(255, 188, 2) !important;
        text-shadow: 3px 2px 5px #000;
    }

    .nav-item:hover::before {
        width: 100%;
        background-color: rgb(255, 188, 2);
        box-shadow: 3px 2px 5px black;
    }

    .nav-item:hover::after {
        width: 100%;
        background-color: rgb(255, 188, 2);
        box-shadow: 3px 2px 5px black;
    }

    .logo {
        position: relative;
        font-weight: bolder;
        font-size: 35px;
        transition: 0.4s ease;
    }

    .logo:hover {
        color: rgb(255, 188, 2) !important;
        text-shadow: 3px 2px 5px #000;
    }

    .logo::before {
        content: "";
        position: absolute;
        bottom: 5px;
        right: 0px;
        width: 0;
        height: 3px;
        border-radius: 5px;
        background-color: #fff;
        transition: 0.4s ease;
    }

    .logo::after {
        content: "";
        position: absolute;
        top: 10px;
        left: 0;
        width: 0;
        height: 3px;
        border-radius: 5px;
        background-color: #fff;
        transition: 0.4s ease;
    }

    .logo:hover::before {
        width: 100%;
        background-color: rgb(255, 188, 2);
        box-shadow: 3px 2px 5px black;
    }

    .logo:hover::after {
        width: 100%;
        background-color: rgb(255, 188, 2);
        box-shadow: 3px 2px 5px black;
    }
</style>

<?php $hostname = "http://localhost/php-projects" ?>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand ml-3 logo" href="<?php echo "$hostname/crud-application" ?>">PHP CRUD APP</a>

    <button class="navbar-toggler border-white mr-3 py-2 text-white" type="button" data-toggle="collapse" data-target="#NavbarContent">
        <span>MENU <i class="fas fa-bars"></i></span>
    </button>
    
    <div class="collapse navbar-collapse" id="NavbarContent">
        <div class="navbar-nav ml-md-auto ml-3 mr-3">
            <a class="nav-item nav-link" href="create.php">Create</a>
            <a class="nav-item nav-link" href="<?php echo "$hostname/crud-application" ?>">Read</a>
            <a class="nav-item nav-link" href="update.php">Update</a>
            <a class="nav-item nav-link" href="delete.php">Delete</a>
        </div>
    </div>
</nav>