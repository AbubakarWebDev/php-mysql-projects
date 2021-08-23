
<?php 
    $post_id = isset($_GET["post_id"])? $_GET["post_id"] : 0; 
    $post_id = (empty($post_id))? 0 : $post_id;
    include_once "header.php" 
?>

<!-- content -->
<section class="content container-fluid my-5">
    <div class="row">

        <!-- Blog Post -->
        <div class="full-post col-lg-8 pl-5">
            <div class="row breadcrums">
                <div class="col-12 px-5">
                    
                    <?php
            
                        $sql = "SELECT post.post_id, post.post_author, post.post_img, post.post_title, post.post_description, post.post_category, post.post_date, category.category_name, users.username FROM post
                        LEFT JOIN category ON post.post_category = category.category_id  
                        LEFT JOIN users ON post.post_author = users.user_id 
                        WHERE post_id = {$post_id};";
            
                        if ($result = mysqli_query($connection, $sql)) 
                        {
                            if(mysqli_num_rows($result) > 0) 
                            {
                                $GLOBALS["row"] = mysqli_fetch_array($result);

                                $post_description = str_replace("\n", "<br>","{$row['post_description']}");

                                echo "<hr>
                                <p class='post-breadcrums'>
                                    Home 
                                    <b> &nbsp; <i class='fas fa-angle-right'></i> &nbsp; </b> 
                                    {$row['category_name']} 
                                    <b> &nbsp; <i class='fas fa-angle-right'></i> &nbsp; </b> 
                                    {$row['post_title']} 
                                </p>
                                <hr>
                                <h1 class='post-title'> {$row['post_title']} </h1>
                                <hr>
                                <div class='post-meta'>
                                    <a href='category.php?category_id={$row['post_category']}'>
                                        <span> &nbsp;&nbsp; <i class='fas fa-tag'></i> &nbsp; {$row['category_name']}</span>
                                    </a>
                                    <a class='text-capitalize' href='author.php?author_id={$row['post_author']}'>
                                        <span> &nbsp;&nbsp; <i class='fas fa-user'></i> &nbsp; {$row['username']}</span>
                                    </a>
                                    <span> &nbsp;&nbsp; <i class='fas fa-clock'></i> &nbsp; {$row['post_date']}</span>
                                </div>
                                <hr>
                                <img class='w-100 img-thumbnail' src='admin/uploads/{$row['post_img']}' alt='Image'>
                                <p class='text-left post-description'>
                                    <br>{$post_description}
                                </p>";
                            }
                            else {
                                echo "<h4 class='text-center my-4'>Nothing to Show Here. No Blog Post is Present.</h4>";
                            }
                        }
                        else {
                            echo "<script>alert('Query Unsuccessfull')</script>";
                        }
                    ?>

                </div>
            </div>
        </div>

        <?php include_once "sidebar.php" ?>

    </div>
</section>

<?php include_once "footer.php" ?>