<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>E-mail</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        <?php

        $query = "SELECT * FROM comments";
        $comments = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($comments)) {

            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_email = $row['comment_email'];
            $comment_content = $row['comment_content'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];

            echo "<tr>";
            echo "<td>{$comment_id}</td>";
            echo "<td>{$comment_author}</td>";
            echo "<td>{$comment_content}</td>";

            // $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
            // $category_display = mysqli_query($connection, $query);

            // queryTest($category_display);

            // while ($row = mysqli_fetch_assoc($category_display)) {

            //     $cat_id = $row['cat_id'];
            //     $cat_title = $row['cat_title'];

            //     echo "<td>{$cat_title}</td>";
            // }

            echo "<td>{$comment_email}</td>";
            echo "<td>{$comment_status}</td>";
            echo "<td>{$comment_post_id}</td>";
            echo "<td>{$comment_date}</td>";
            echo "<td><a href='posts.php?delete={$comment_id}'>Approve</a></td>";
            echo "<td><a href='posts.php?delete={$comment_id}'>Unapprove</a></td>";
            echo "<td><a href='posts.php?delete={$comment_id}'>Delete</a></td>";
            echo "</tr>";
        }

        ?>
    </tbody>
</table>

<?php

if (isset($_GET['delete'])) {

    $delete_post_id = $_GET['delete'];

    $query = "DELETE FROM posts WHERE post_id = {$delete_post_id}";
    $delete_query = mysqli_query($connection, $query);
    header("Location: posts.php");

    queryTest($delete_query);
}

?>