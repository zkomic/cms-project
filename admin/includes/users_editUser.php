<br>
<small>Edit User</small>
</h1>

<?php

if (isset($_GET['user_id'])) {

    $user_id = $_GET['user_id'];

    $query = "SELECT * FROM users WHERE user_id = {$user_id}";
    $user_query = mysqli_query($connection, $query);
    queryTest($user_query);

    while ($row = mysqli_fetch_assoc($user_query)) {

        $user_id = $row['user_id'];
        $username = $row['username'];
        $db_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_role = $row['user_role'];
    }


    if (isset($_POST['edit_user'])) {

        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        $username = $_POST['username'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];

        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}'";

        if (!empty($user_password) && $db_password != $user_password) {
            $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
            $query .= ", user_password = '{$user_password}'";
        }

        $query .= " WHERE user_id = {$user_id}";

        $update_user = mysqli_query($connection, $query);
        queryTest($update_user);
        redirect("users.php");
    }
} else { //no user_id in url

    redirect("index.php");
}

?>

<form action="" method="post" enctype="multipart/form-data"> <!-- enctype="multipart/form-data" za file upload -->
    <div class="form-group">
        <label for="user_firstname">First name</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname ?>">
    </div>
    <div class="form-group">
        <label for="user_lastname">Last name</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname ?>">
    </div>
    <div class="form-group">
        <label for="user_role">Role</label><br>
        <select name="user_role" id="user_role">

            <?php

            if ($user_role == 'admin') {

                echo "<option value='admin' selected='selected'>Admin</option>";
                echo "<option value='subscriber' >Subscriber</option>";
            } else {

                echo "<option value='admin'>Admin</option>";
                echo "<option value='subscriber' selected='selected'>Subscriber</option>";
            }

            ?>

        </select>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username ?>" required>
    </div>
    <div class="form-group">
        <label for="user_email">E-mail</label>
        <input type="text" class="form-control" name="user_email" value="<?php echo $user_email ?>" required>
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password" autocomplete="off" placeholder="New password...">
    </div>
    <br>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update User">
    </div>
</form>