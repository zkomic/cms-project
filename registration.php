<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $error = [
        'username' => '',
        'email' => '',
        'password' => '',
        'empty' => ''
    ];

    if (strlen($username) < 4) {

        $error['username'] = 'Username needs to be longer.';
    }

    if (strlen($username) == 0 || strlen($email) == 0 || strlen($password) == 0) {

        $error['empty'] = 'Fields should not be empty!';
    }

    if (usernameExists($username)) {

        $error['username'] = "Username " . $username . " already exists.";
    }

    if (emailExists($email)) {

        $error['email'] = "User with " . $email . " already exists. Please, <a href='index.php'>login</a>. ";
    }

    foreach ($error as $key => $value) {

        if (empty($value)) {

            unset($error[$key]);
            userLogin($username, $password);
        }
    }

    if(empty($error)) {

        userRegistration($username, $email, $password);
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

                            if (!empty($error['username'])) {

                                echo "<div class='alert alert-danger' role='alert'>{$error['username']}</div>";
                            } else if (!empty($error['email'])) {

                                echo "<div class='alert alert-danger' role='alert'>{$error['email']}</div>";
                            } else if (!empty($error['empty'])) {

                                echo "<div class='alert alert-danger' role='alert'>{$error['empty']}</div>";
                            } 
                            ?>

                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username" autocomplete="on" value="<?php echo isset($username) ? $username : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@email.com" autocomplete="on" value="<?php echo isset($email) ? $email : '' ?>">
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