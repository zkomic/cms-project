<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>First name</th>
            <th>Last name</th>
            <th>E-mail</th>
            <th>Role</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        <?php

        $query = "SELECT * FROM users";
        $users = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($users)) {

            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];

            echo "<tr>";
            echo "<td>{$user_id}</td>";
            echo "<td>{$username}</td>";
            echo "<td>{$user_firstname}</td>";
            echo "<td>{$user_lastname}</td>";
            echo "<td>{$user_email}</td>";
            echo "<td>{$user_role}</td>";

            // $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
            // $comment_post = mysqli_query($connection, $query);
            // queryTest($comment_post);

            // while ($row = mysqli_fetch_assoc($comment_post)) {
            //     $post_id = $row['post_id'];
            //     $post_title = $row['post_title'];

            //     echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";
            // }

            echo "<td><a href='comments.php?approve={$user_id}'>Approve</a></td>";
            echo "<td><a href='comments.php?unapprove={$user_id}'>Unapprove</a></td>";
            echo "<td><a href='comments.php?delete={$user_id}'>Delete</a></td>";
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