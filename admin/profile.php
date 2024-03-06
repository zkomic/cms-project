<?php include "includes/admin_header.php" ?>
<?php

$username = '';
$user_password = '';
$user_firstname = '';
$user_lastname = '';
$user_email = '';

if (isLoggedIn()) {

    $query = "SELECT * FROM users WHERE username = '{$_SESSION['username']}'";
    $fetch_user = mysqli_query($connection, $query);
    queryTest($fetch_user);

    while ($row = mysqli_fetch_assoc($fetch_user)) {

        $user_id = $row['user_id'];
        $username = $row['username'];
        $db_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
    }
}

?>

<?php

if (isset($_POST['edit_user'])) {

    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $query = "UPDATE users SET ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "username = '{$username}', ";
    $query .= "user_email = '{$user_email}'";

    if (!empty($user_password) && $db_password != $user_password) {
        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
        $query .= ", user_password = '{$user_password}'";
    }

    $query .= "WHERE username = '{$username}'";

    $update_user = mysqli_query($connection, $query);
    queryTest($update_user);
    redirect("profile.php");
}


?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Profile
                        <br>
                        <small>
                            <?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname'] ?>
                        </small>
                    </h1>

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
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo $username ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_email">E-mail</label>
                            <input type="text" class="form-control" name="user_email" value="<?php echo $user_email ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input type="password" class="form-control" name="user_password" autocomplete="off" placeholder="New password...">
                        </div>
                        <br>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="edit_user" value="Update Profile">
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>