<?php include "includes/db.php" ?>
<?php include "includes/header.php" ?>
<!-- Navigation -->
<?php include "includes/navigation.php" ?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php

            if (isset($_GET['category'])) {
                $get_cat_id = $_GET['category'];
            }

            $page = 1;
            $per_page = 5;

            if (isset($_GET['page'])) {

                $page = $_GET['page'];
            }

            if ($page == "" || $page == 1) {

                $page_1 = 0;
            } else {

                $page_1 = ($page * $per_page) - $per_page;
            }

            // pagination count
            $query = "SELECT * FROM posts WHERE post_status = 'published' AND post_category_id = {$get_cat_id}";
            $posts_count = mysqli_query($connection, $query);
            $posts_count = mysqli_num_rows($posts_count);
            $posts_count = ceil($posts_count / $per_page);

            $query = "SELECT * FROM categories WHERE cat_id = {$get_cat_id}";
            $category = mysqli_query($connection, $query);
            queryTest($category);

            while ($row = mysqli_fetch_assoc($category)) {
                $category_name = $row['cat_title'];
            }

            ?>

            <h1 class="page-header">
                <?php echo $category_name ?> Posts
            </h1>

            <?php

            $query = "SELECT * FROM posts WHERE post_category_id = $get_cat_id AND post_status = 'published' ORDER BY post_id DESC LIMIT {$page_1}, {$per_page}";
            $posts = mysqli_query($connection, $query);
            queryTest($posts);

            if (mysqli_num_rows($posts) == 0) { // checking if there are published posts

                echo "<h1 class='text-center' >No posts, sorry.</h1><br>";
            } else {
                while ($row = mysqli_fetch_assoc($posts)) {

                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_user_id = $row['post_user_id'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_cont_tmp = substr($row['post_content'], 0, 250);
                    $post_content = substr($post_cont_tmp, 0, strrpos($post_cont_tmp, ' ')); // cuts on the end of last word

            ?>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>">
                            <?php echo $post_title; ?>
                        </a>
                    </h2>

                    <?php

                    $query = "SELECT * FROM users WHERE user_id = {$post_user_id}";
                    $author = mysqli_query($connection, $query);
                    queryTest($author);

                    while ($row = mysqli_fetch_assoc($author)) {

                        $author_id = $row['user_id'];
                        $author_firstname = $row['user_firstname'];
                        $author_lastname = $row['user_lastname'];
                    }

                    ?>

                    <p class="lead">by <a href="author_posts.php?author=<?php echo $author_id; ?>&p_id=<?php echo $post_id; ?>"><?php echo $author_firstname . " " . $author_lastname ?></a></p>
                    <p>
                        <span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?>
                        at 10:00 PM
                    </p>
                    <hr />
                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="" />
                    </a>
                    <hr />
                    <p>
                        <?php echo $post_content; ?>...
                    </p>
                    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr />

            <?php }
            } ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>
    </div>
    <!-- /.row -->

    <hr />

    <!-- Pagination -->
    <ul class="pager">

        <?php

        for ($i = 1; $i <= $posts_count; $i++) {

            if ($i == $page) {

                echo "<li><a class='active-link' href='category.php?category={$get_cat_id}&page={$i}'>{$i}</a></li>";
            } else {

                echo "<li><a href='category.php?category={$get_cat_id}&page={$i}'>{$i}</a></li>";
            }
        }

        ?>

    </ul>

    <!-- Footer -->
    <?php include "includes/footer.php" ?>
</div>