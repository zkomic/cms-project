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

            if (isset($_GET['p_id'])) {

                $post_id = $_GET['p_id'];

                //post_views_count increment
                $query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = {$post_id}";
                $views_count = mysqli_query($connection, $query);
                queryTest($views_count);


                $query = "SELECT * FROM posts WHERE post_id = $post_id ";
                $posts = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($posts)) {

                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];

            ?>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="#"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">by <a href="index.php"><?php echo $post_author ?></a></p>
                    <p>
                        <span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?>
                        at 10:00 PM
                    </p>
                    <hr />
                    <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="" />
                    <hr />
                    <p>
                        <?php echo $post_content ?>
                    </p>
                    <hr />

            <?php }
            } else {

                // if there is no post_id, redirect to home page
                header("Location: index.php");
            }

            ?>

            <!-- Blog Comments -->

            <?php

            if (isset($_POST['create_comment'])) {

                $p_id = $_GET['p_id'];

                $comment_author = $_POST['comment_author'];
                $comment_email = $_POST['comment_email'];
                $comment_content = $_POST['comment_content'];

                if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {

                    $query = "INSERT INTO comments ";
                    $query .= "(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                    $query .= "VALUES ($p_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";

                    $new_comment = mysqli_query($connection, $query);
                    queryTest($new_comment);
                } else {

                    echo "<script>alert('Fields can not be empty.')</script>";
                }

                // removes data when reloading after submit
                header("Location: post.php?p_id=$post_id");
            }



            ?>

            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="" method="post" role="form">
                    <div class="form-group">
                        <label for="comment_author">Author: </label>
                        <input type="text" class="form-control" name="comment_author">
                    </div>
                    <div class="form-group">
                        <label for="comment_email">Email: </label>
                        <input type="email" class="form-control" name="comment_email">
                    </div>
                    <div class="form-group">
                        <label for="comment_content">Comment: </label>
                        <textarea class="form-control" name="comment_content" rows="3"></textarea>
                    </div>
                    <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <hr>

            <!-- Posted Comments -->

            <!-- Comment -->

            <?php

            if (isset($_GET['p_id'])) {

                $p_id = $_GET['p_id'];
            }

            $query = "SELECT * FROM comments WHERE comment_post_id = {$p_id} ";
            $query .= "AND comment_status = 'approved' ";
            $query .= "ORDER BY comment_id DESC";

            $post_comments = mysqli_query($connection, $query);
            queryTest($post_comments);

            while ($row = mysqli_fetch_assoc($post_comments)) {

                $comment_date = $row['comment_date'];
                $comment_author = $row['comment_author'];
                $comment_content = $row['comment_content'];

            ?>

                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?></small>
                    </div>
                </div>

            <?php

            }

            ?>

            <br>
        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>
    </div>
    <!-- /.row -->

    <hr />

    <!-- Footer -->
    <?php include "includes/footer.php" ?>
</div>