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

            if (isset($_POST['submit'])) {
                $search = $_POST['search'];

                $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
                $search_query = mysqli_query($connection, $query);

                if (!$search_query) {
                    die("Query failed: " . mysqli_error($connection));
                }

                $count = mysqli_num_rows($search_query);
                if ($count == 0) {
                    echo "No results";
                } else {

                    while ($row = mysqli_fetch_assoc($search_query)) {

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
                                <?php echo $post_title ?>
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

                        <p class="lead">by <a href="/cms-project/author/<?php echo $author_id; ?>"><?php echo $author_firstname . " " . $author_lastname ?></a></p>
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

            <?php }
                }
            } ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>
    </div>
    <!-- /.row -->

    <hr />

    <!-- Footer -->
    <?php include "includes/footer.php" ?>
</div>