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
            <th>Change Status</th>
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
            if ($comment_status === 'approved') {

                echo "<td>Approved</td>";
            } else {

                echo "<td>Unapproved</td>";
            }

            $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
            $comment_post = mysqli_query($connection, $query);
            queryTest($comment_post);

            while ($row = mysqli_fetch_assoc($comment_post)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];

                echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";
            }


            echo "<td>{$comment_date}</td>";
            if ($comment_status === 'approved') {

                echo "<td><a href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>";
            } else {

                echo "<td><a href='comments.php?approve={$comment_id}'>Approve</a></td>";
            }
            echo "<td><a class='icons' onClick=\"javascript: return confirm('Are you sure you want to delete this comment?'); \" href='comments.php?delete={$comment_id}'><i class='fa fa-trash'></i></a></td>";
            echo "</tr>";
        }

        ?>
    </tbody>
</table>

<?php

if (isset($_GET['approve'])) {

    $comment_id = $_GET['approve'];

    $query = "UPDATE comments SET comment_status = 'approved'";
    $query .= "WHERE comment_id = $comment_id";
    $approve_query = mysqli_query($connection, $query);
    header("Location: comments.php");

    queryTest($approve_query);
}


if (isset($_GET['unapprove'])) {

    $comment_id = $_GET['unapprove'];

    $query = "UPDATE comments SET comment_status = 'unapproved'";
    $query .= "WHERE comment_id = $comment_id";
    $unapprove_query = mysqli_query($connection, $query);
    header("Location: comments.php");

    queryTest($unapprove_query);
}

if (isset($_GET['delete'])) {

    $delete_comment_id = $_GET['delete'];

    $query = "DELETE FROM comments WHERE comment_id = {$delete_comment_id}";
    $delete_query = mysqli_query($connection, $query);
    header("Location: comments.php");

    queryTest($delete_query);
}

?>