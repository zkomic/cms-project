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

            if (isset($_GET['author'])) {

                $get_author_id = $_GET['author'];
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
            $query = "SELECT * FROM posts WHERE post_user_id = '{$get_author_id}' AND post_status = 'published'";
            $posts_count = mysqli_query($connection, $query);
            $posts_count = mysqli_num_rows($posts_count);
            $posts_count = ceil($posts_count / $per_page);

            $query = "SELECT * FROM posts WHERE post_user_id = '{$get_author_id}' AND post_status = 'published' ORDER BY post_id DESC LIMIT {$page_1}, {$per_page}";
            $posts = mysqli_query($connection, $query);
            queryTest($posts);

            while ($row = mysqli_fetch_assoc($posts)) {

                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_user_id = $row['post_user_id'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];

            ?>

                <!-- First Blog Post -->
                <h2>
                    <a href="/cms-project/post/<?php echo $post_id; ?>">
                        <?php echo $post_title ?></a>
                </h2>
                <br>
                <p>
                    <span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?>
                    at 10:00 PM
                </p>
                <hr />
                <a href="/cms-project/post/<?php echo $post_id; ?>">
                    <img class="img-responsive" src="/cms-project/images/<?php echo imagePlaceholder($post_image); ?>" alt="" />
                </a>
                <hr />
                <p>
                    <?php echo $post_content ?>
                </p>
                <a class="btn btn-primary" href="/cms-project/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr />
                <br>

            <?php } ?>

            <hr>
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

                echo "<li><a class='active-link' href='author_posts.php?author={$get_author_id}&page={$i}'>{$i}</a></li>";
            } else {

                echo "<li><a href='author_posts.php?author={$get_author_id}&page={$i}'>{$i}</a></li>";
            }
        }

        ?>

    </ul>

    <!-- Footer -->
    <?php include "includes/footer.php" ?>
</div>