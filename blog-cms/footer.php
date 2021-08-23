
<!-- Site Footer -->
<footer>
    <div class="footer-content container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-12">
                        <h3>About us</h3>
                    </div>
                </div>
                <div class="row my-4 align-items-center">
                    <div class="col-md-4 mb-3">
                        <img class="img-fluid rounded-circle border border-3" src="images/abubakar.png" alt="">
                    </div>
                    <div class="col-md-8">
                        <p>Hello, my name is Muhammad Abubakar.I am the Admin of this Blog.In this Blog, you will gain
                            Lots of information about WebDev, Tech and Computer Tips & Tricks</p>
                        <a class="footer-about-link" href="#">Learn More</a>
                    </div>
                </div>
                <div class="row mb-4 mb-lg-0">
                    <div class="footer-social justify-content-md-center justify-content-start col-12">
                        <span><i class="fab fa-facebook"></i></span>
                        <span><i class="fab fa-youtube"></i></span>
                        <span><i class="fab fa-instagram"></i></span>
                        <span><i class="fab fa-twitter"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-12">
                        <h3>Contact Form</h3>
                        <form action="" class="mb-4 mb-lg-0">
                            <div class="mb-3">
                                <label for="Name" class="form-label">Name *</label>
                                <input type="text" class="form-control" id="Name"
                                    placeholder="Enter Name">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address *</label>
                                <input type="email" class="form-control" id="email"
                                    placeholder="Enter Email">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message *</label>
                                <textarea class="form-control" id="message" rows="5" placeholder="Enter Your Message"></textarea>
                            </div>
                            <button class="btn btn-danger w-100">Submit</button>
                        </form>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-12">
                        <h3>Popular Post</h3>

                        <?php 
                            $limit = 4;

                            $sql = "SELECT post.post_id, post.post_author, post.post_img, post.post_title, post.post_description, post.post_category, category.category_name FROM post
                            LEFT JOIN category ON post.post_category = category.category_id  
                            ORDER BY post.post_id DESC 
                            LIMIT {$limit};";

                            if ($result = mysqli_query($connection, $sql)) 
                            {
                                if(mysqli_num_rows($result) > 0) 
                                {
                                    while($row = mysqli_fetch_array($result)) 
                                    {
                                        echo "
                                        <div class='d-flex mt-3 position-relative popular-post-widget'>
                                            <div class='w-50'>
                                                <a href='post.php?post_id={$row['post_id']}'><img class='img-fluid' src='admin/uploads/{$row['post_img']}' class='w-100' alt='Image'></a>
                                            </div>
                                            <div class='title'>
                                                <a href='post.php?post_id={$row['post_id']}'><h5>{$row['post_title']}</h5></a>
                                                <div>
                                                    <a href='category.php?category_id={$row['post_category']}'><span>&nbsp;&nbsp;<i class='fas fa-tag'></i>&nbsp;{$row['category_name']}</span></a>
                                                </div>
                                            </div>
                                        </div>";
                                    }
                                }
                            }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area">
        Copyright © 2019-<?php echo date("Y"); ?>&nbsp;&nbsp;<a class="tm-link" target="_blank" href="https://techmemorise.blogspot.com/" title="Tech Memorise">Tech Memorise</a>&nbsp;&nbsp;|&nbsp;&nbsp;All Rights Reserved
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {            
        $("#navbar").on("click", "#search-open", function () {
            $("#navbar").html(`
            <form action="search.php" method="get" class="navbar-search">
                 <input id="search" name="search" type="text" placeholder="Search this Blog">
                 <div id="search-close" class="nav-search">
                     <i class="fas fa-times"></i>
                 </div>
             </form>`);

             $("#search").focus();
        });

        $("#navbar").on("click", "#search-close", function () {
            $("#navbar").html(`
             <button class="navbar-toggler ml-4" type="button" data-toggle="collapse" data-target="#NavbarContent">
                 <span><i class="fas fa-bars"></i></span>
             </button>
             <div id="search-open" class="nav-search">
                 <i class="fas fa-search"></i>
             </div>
             <div class="collapse navbar-collapse" id="NavbarContent">
                 <div class="navbar-nav text-center ml-0 ml-md-3 mr-auto">
                     <a class="nav-item nav-link" href="<?php echo $hostname ?>blog-cms">Home</a>
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
             </div>`);
        });
    });
</script>

</body>

</html>