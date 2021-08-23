
<?php 
    $search = isset($_GET["search"])? $_GET["search"] : ""; 
    include_once "header.php" 
?>

<!-- content -->
<section class="content container-fluid my-5">
    <div class='row justify-content-start ml-4'>
        <div class='col-12'>
            <?php 
                echo "<h3 class='text-uppercase' > SEARCH FOR: {$search} </h3>";
            ?>
        </div>
    </div>
    <div class='row'>
        <div class='blog-post col-lg-8'>

        <?php 

            $limit = 3;
            $page_no = isset($_GET["page_no"])? $_GET["page_no"] : 1;
            $offset = ($page_no - 1) * $limit;

            $sql = "SELECT post.post_id, post.post_author, post.post_img, post.post_title, post.post_description, post.post_category, post.post_date, category.category_name, users.username FROM post
            LEFT JOIN category ON post.post_category = category.category_id  
            LEFT JOIN users ON post.post_author = users.user_id 
            WHERE category_name LIKE '%{$search}%' OR post_title LIKE '%{$search}%' OR username LIKE '%{$search}%'
            ORDER BY post.post_id DESC
            LIMIT {$offset}, {$limit};";

            if ($result = mysqli_query($connection, $sql)) 
            {
                if(mysqli_num_rows($result) > 0) 
                {
                    while($row = mysqli_fetch_array($result)) 
                    {
                        $post_description = substr($row['post_description'], 0, 180);

                        echo "
                        <div class='row post g-0 position-relative'>
                            <div class='col-md-6 mb-md-0 p-md-4'>
                            <a href='post.php?post_id={$row['post_id']}'><img class='img-thumbnail' src='admin/uploads/{$row['post_img']}' class='w-100' alt='Image'></a>
                            </div>
                            <div class='col-md-6 py-4 pl-md-0'>
                                <a href='post.php?post_id={$row['post_id']}'><h1>{$row['post_title']}</h1></a>
                                <div>
                                    <a href='category.php?category_id={$row['post_category']}'><span>&nbsp;&nbsp;<i class='fas fa-tag'></i>&nbsp;{$row['category_name']}</span></a>
                                    <a href='author.php?author_id={$row['post_author']}'><span>&nbsp;&nbsp;<i class='fas fa-user'></i>&nbsp;{$row['username']}</span></a>
                                    <span>&nbsp;&nbsp;<i class='fas fa-clock'></i>&nbsp;{$row['post_date']}</span>
                                </div>
                                <p>{$post_description}.....</p>
                                <a href='post.php?post_id={$row['post_id']}'><button class='btn-danger'>Read More</button></a>
                            </div>
                        </div>";
                    }
                }
                else {
                    echo "<h4 class='text-center my-4'>Nothing to Show Here. No Blog Post is Present.</h4>";
                }
            }
            else 
            {
                echo "<p>Query Unsuccessfull</p>";
            }

            echo "<div class='row mt-4 ml-3 pagination'>
            <div class='col-12 d-flex align-items-center justify-content-start'>";

            $sql = "SELECT post.post_id, post.post_author, post.post_img, post.post_title, post.post_description, post.post_category, post.post_date, category.category_name, users.username FROM post
            LEFT JOIN category ON post.post_category = category.category_id  
            LEFT JOIN users ON post.post_author = users.user_id 
            WHERE category_name LIKE '%{$search}%' OR post_title LIKE '%{$search}%' OR username LIKE '%{$search}%'";

            if ($result = mysqli_query($connection, $sql)) 
            {
                if(mysqli_num_rows($result) > 0) {
                    $total_records = mysqli_num_rows($result);
                    $total_pages = ceil($total_records / $limit);
                    $next_page = $page_no + 1;
                    $prev_page = $page_no - 1;
                    $active = "";

                    if ($page_no > 1) {
                        echo "<span><a href='search.php?search={$search}&page_no={$prev_page}'><i class='fas fa-angle-left'></i></a></span>";
                    }

                    for ($i=1; $i <= $total_pages; $i++) {
                        if ($i == $page_no) {
                            $active = "active";
                        }
                        else {
                            $active = "";
                        }
                        echo "<span class='$active'><a href='search.php?search={$search}&page_no=$i'>$i</a></span>";
                    }

                    if ($page_no > 3) {
                        echo "
                            <div>....</div>
                            <span><a href='search.php?search={$search}&page_no={$total_pages}'>$total_pages</a></span>";                            
                    }
                    
                    if ($page_no != $total_pages) {
                        echo "<span><a href='search.php?search={$search}&page_no={$next_page}'><i class='fas fa-angle-right'></i></a></span>";
                    }

                }
                echo "</div></div>";
            }
            else {
                echo "<script>alert('Query Unsuccessfull')</script>";
            }
        ?>

        </div>

        <?php include_once "sidebar.php" ?>

    </div>
</section>

<?php include_once "footer.php" ?>
