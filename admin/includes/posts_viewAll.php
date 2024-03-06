</h1>

<?php

include "delete_modal.php";

if (isset($_POST['checkBoxArray'])) {

    foreach ($_POST['checkBoxArray'] as $postValueId) {

        $bulk_option = $_POST['bulk_options'];

        switch ($bulk_option) {
            case 'published':
                $query = "UPDATE posts SET post_status = 'published' WHERE post_id = {$postValueId}";
                $update_to_publish = mysqli_query($connection, $query);
                queryTest($update_to_publish);
                break;
            case 'draft':
                $query = "UPDATE posts SET post_status = 'draft' WHERE post_id = {$postValueId}";
                $update_to_draft = mysqli_query($connection, $query);
                queryTest($update_to_draft);
                break;
            case 'clone':
                $query  = "SELECT * FROM posts WHERE post_id = {$postValueId}";
                $post_to_clone = mysqli_query($connection, $query);
                queryTest($post_to_clone);

                while ($row = mysqli_fetch_assoc($post_to_clone)) {

                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_date = $row['post_date'];
                    $post_user_id = $row['post_user_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_content = $row['post_content'];
                }

                $query = "INSERT INTO posts (post_category_id, post_title, post_user_id, post_date, post_image, post_content, post_tags, post_status) ";
                $query .= "VALUES ({$post_category_id}, '{$post_title}', '{$post_user_id}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
                $cloned_post = mysqli_query($connection, $query);
                queryTest($cloned_post);
                break;
            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
                $delete = mysqli_query($connection, $query);
                queryTest($delete);
                break;
        }
    }
}

?>

<form action="" method="post">
    <table class="table table-bordered table-hover">
        <div class="col-xs-4" id="bulkOptionsContainer">
            <select name="bulk_options" id="" class="form-control">
                <option value="">Select Option</option>
                <option value="published">Status to Published</option>
                <option value="draft">Status to Draft</option>
                <option value="clone">Clone</option>
                <option value="delete">Delete</option>
            </select>
        </div>
        <div class="col-xs-4" id="bulkOptionsContainerButtons">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="./posts.php?source=add_post">New Post</a>
        </div>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Views</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>

            <?php

            $query = "SELECT p.post_id, p.post_title, p.post_category_id, p.post_status, p.post_image, p.post_tags, p.post_date, p.post_views_count, ";
            $query .= "c.cat_id, c.cat_title, u.user_firstname, u.user_lastname ";
            $query .= "FROM posts p ";
            $query .= "LEFT JOIN categories c ";
            $query .= "ON p.post_category_id = c.cat_id ";
            $query .= "LEFT JOIN users u ";
            $query .= "ON p.post_user_id = u.user_id ";
            $query .= "ORDER BY p.post_id DESC";
            $posts = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($posts)) {

                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_date = $row['post_date'];
                $post_views_count = $row['post_views_count'];
                $cat_title = $row['cat_title'];
                $cat_id = $row['cat_id'];
                $user_firstname = $row['user_firstname'];
                $user_lastname = $row['user_lastname'];

                echo "<tr>";

            ?>

                <th><input class="checkBox" type="checkbox" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></th>


                <?php

                echo "<td>$post_id</td>";
                echo "<td>$user_firstname $user_lastname</td>";
                echo "<td>{$post_title}</td>";
                echo "<td>{$cat_title}</td>";

                if ($post_status == 'published') {

                    echo "<td>Published</td>";
                } else {

                    echo "<td>Draft</td>";
                }
                echo "<td><img width='100' src='../images/$post_image' alt='image'></td>";
                echo "<td>{$post_tags}</td>";

                // comment counter
                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                $comment_count_query = mysqli_query($connection, $query);
                queryTest($comment_count_query);
                $comment_count = mysqli_num_rows($comment_count_query);

                if ($comment_count == 0) {

                    echo "<td>{$comment_count}</td>";
                } else {

                    echo "<td><a href='comments.php?source=comments_post&post_id=$post_id'>{$comment_count}</a></td>";
                }

                echo "<td>{$post_views_count}</td>";
                echo "<td>{$post_date}</td>";
                echo "<td><a class='icons' href='../post.php?p_id={$post_id}'><i class='fa fa-eye' aria-hidden='true'></i>&nbsp;&nbsp;</a>";
                echo "<a class='icons' href='posts.php?source=edit_post&p_id={$post_id}'><i class='fa fa-edit'></i>&nbsp;&nbsp;</a>";

                ?>
                <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');">
                    <input type="hidden" name="post_id" value="<?php echo $post_id ?>">

                    <?php
                    echo "<td><input class='btn btn-danger' type='submit' name='delete' value='Delete'></td>"
                    ?>

                </form>

            <?php

                echo "</tr>";
            }

            ?>
        </tbody>
    </table>
</form>

<?php

if (isset($_POST['delete'])) {

    $delete_post_id = $_POST['post_id'];

    $query = "DELETE FROM posts WHERE post_id = {$delete_post_id}";
    $delete_query = mysqli_query($connection, $query);
    redirect("posts.php");

    queryTest($delete_query);
}

?>

<script>
    $(document).ready(function() {

        $(".delete-link").on('click', function() {

            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete=" + id + " ";
            //alert(delete_url);
            $(".modal-delete-link").attr("href", delete_url);
            $("#deleteModal").modal('show');
        });
    });
</script>

<script>
    function confirmDelete(postId) {
        return confirm('Are you sure you want to delete this post?');
    }
</script>