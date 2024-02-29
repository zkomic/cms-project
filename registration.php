<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php

if (isset($_POST['submit'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($email) && !empty($password)) {
        $username = mysqli_real_escape_string($connection, $username);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);

        $query = "SELECT randSalt FROM users";
        $randSalt = mysqli_query($connection, $query);
        queryTest($randSalt);
        $row = mysqli_fetch_array($randSalt);
        $salt = $row['randSalt'];

        //encrypting password
        $password = crypt($password, $salt);

        $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
        $query .= "VALUES ('{$username}', '{$email}', '{$password}', 'subscriber')";
        $register_user = mysqli_query($connection, $query);
        queryTest($register_user);

        //last id
        $p_id = mysqli_insert_id($connection);

        $message = "Profile for user <strong>{$username}</strong> created succesfully! <a href='admin/users.php?source=edit_user&user_id={$p_id}'>Click here to edit details.</a>";
    } else {

        $message_error = 'Fields should not be empty!';
    }
} else {

    $message_error = "";
}

?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1><br>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">

                            <?php
                            if (!empty($message_error)) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $message ?>
                                </div>

                            <?php
                            }
                            ?>

                            <?php
                            if (!empty($message)) {
                            ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo $message ?>
                                </div>

                            <?php
                            }
                            ?>

                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@email.com">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>