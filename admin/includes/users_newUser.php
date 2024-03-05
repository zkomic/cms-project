<br>
<small>New User</small>
</h1>

<?php

if (isset($_POST['create_user'])) {

    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    //$user_date = date('d-m-y');

    //image
    //$post_image = $_FILES['post_image']['name'];
    //$post_image_tmp = $_FILES['post_image']['tmp_name']; //tmp location
    //move_uploaded_file($post_image_tmp, "../images/$post_image"); //moving img from tmp location to ../images

    $query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) ";
    $query .= "VALUES('{$user_firstname}','{$user_lastname}','{$user_role}','{$username}','{$user_email}','{$password}')";

    $new_user = mysqli_query($connection, $query);

    queryTest($new_user);
    //header("Location: users.php");

    echo "
    <div class='alert alert-success'>User 
        <strong>{$username}</strong>
    created succesfully!
        <a href='users.php'>Click here to view all users.</a>
  </div>";
}

?>

<form action="" method="post" enctype="multipart/form-data"> <!-- enctype="multipart/form-data" za file upload -->
    <div class="form-group">
        <label for="user_firstname">First name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="user_lastname">Last name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <label for="user_role">Role</label><br>
        <select name="user_role" id="user_role">
            <option value="admin">Admin</option>
            <option value="subscriber" selected="selected">Subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" required>
    </div>
    <div class="form-group">
        <label for="user_email">E-mail</label>
        <input type="text" class="form-control" name="user_email" required>
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="text" class="form-control" name="user_password" required>
    </div>
    <!-- <div class="from-group">
        <label for="post_image">Image</label>
        <input type="file" name="post_image">
    </div> -->
    <br>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>
</form>