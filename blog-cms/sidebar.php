<!-- SideBar -->
<div class="sidebar col-lg-4">
    <div class="row mt-4">
        <div class="col-12 widget">
            <h3>Search This Blog</h3>
            <form action="search.php" method="get" class="input-group mb-3">
                <input type="search" name="search" class="form-control w-75" placeholder="Search This Blog" aria-describedby="search-btn">
                <button class="btn btn-danger w-25" type="submit" id="search-btn">Search</button>
            </form>
        </div>
    </div>

    <style>
        .sidebar div.widget h3 {
            text-transform: uppercase !important;
        }
    </style>

    <div class="row mt-4">
        <div class="col-12 widget">
            <h3>Recent Post</h3>

            <?php 

                $limit = 3;
                
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
                                    <a href='post.php?post_id={$row['post_id']}'><img class='img-thumbnail' src='admin/uploads/{$row['post_img']}' class='w-100' alt='Image'></a>
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

    <div class="row mt-5">
        <div class="col-12 widget">
            <h3 class="mb-4">Popular Categories</h3>

            <?php 

                $limit = 6;
                $sql = "SELECT * FROM category ORDER BY category_id DESC LIMIT $limit";
            
                if ($result = mysqli_query($connection, $sql)) 
                {
                    if(mysqli_num_rows($result) > 0) 
                    {
                        while($row = mysqli_fetch_array($result)) 
                        {
                            echo "
                            <div class='row popular-categories mx-2'>
                                <div class='col-12 position-relative d-flex justify-content-between'>
                                    <p>&nbsp;<i class='fas fa-angle-right'></i>&nbsp; {$row['category_name']}</p>
                                    <a href='category.php?category_id={$row['category_id']}' class='stretched-link'>{$row['no_of_post']}</a>
                                </div>
                                <hr>
                            </div>";
                        }
                    }
                }
            
            ?>
            
        </div>
    </div>
</div>