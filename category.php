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
                $cat_id = $_GET['category'];
            }

            $query = "SELECT * FROM posts WHERE post_id = $cat_id";
            $posts = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($posts)) {

                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_cont_tmp = substr($row['post_content'], 0, 250);
                $post_content = substr($post_cont_tmp, 0, strrpos($post_cont_tmp, ' ')); // cuts on the end of last word

            ?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                        <?php echo $post_title; ?>
                    </a>
                </h2>
                <p class="lead">by <a href="index.php"><?php echo $post_author; ?></a></p>
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

            <?php } ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>
    </div>
    <!-- /.row -->

    <hr />

    <!-- Footer -->
    <?php include "includes/footer.php" ?>
</div>