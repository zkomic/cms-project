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

            echo "<td><a href='users.php?change_to_admin={$user_id}'>Make admin</a></td>";
            echo "<td><a href='users.php?change_to_subsc={$user_id}'>Make subscriber</a></td>";
            echo "<td><a href='users.php?source=edit_user&user_id={$user_id}'>Edit</a></td>";
            echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
            echo "</tr>";
        }

        ?>
    </tbody>
</table>

<?php

if (isset($_GET['change_to_admin'])) {

    $user_id = $_GET['change_to_admin'];

    $query = "UPDATE users SET user_role = 'admin' ";
    $query .= "WHERE user_id = $user_id";
    $changeToAdmin_query = mysqli_query($connection, $query);
    queryTest($changeToAdmin_query);

    header("Location: users.php");
}


if (isset($_GET['change_to_subsc'])) {

    $user_id = $_GET['change_to_subsc'];

    $query = "UPDATE users SET user_role = 'subscriber' ";
    $query .= "WHERE user_id = $user_id";
    $changeToSubsc_query = mysqli_query($connection, $query);
    queryTest($changeToSubsc_query);

    header("Location: users.php");
}

if (isset($_GET['delete'])) {

    $delete_user_id = $_GET['delete'];

    $query = "DELETE FROM users WHERE user_id = {$delete_user_id}";
    $delete_query = mysqli_query($connection, $query);
    queryTest($delete_query);

    header("Location: users.php");
}

?>