<?php include "includes/admin_header.php" ?>
<?php

if (isset($_SESSION['username'])) {

    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $fetch_user = mysqli_query($connection, $query);
    queryTest($fetch_user);

    while ($row = mysqli_fetch_assoc($fetch_user)) {

        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        //$user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }
}

?>

<?php 

if (isset($_POST['edit_user'])) {

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

    // fetch image from db so that is not empty after editing
    // if (empty($post_image)) {

    //     $query = "SELECT * FROM posts WHERE post_id = {$p_id} ";
    //     $fetch_image = mysqli_query($connection, $query);

    //     while ($row = mysqli_fetch_assoc($fetch_image)) {
    //         $post_image = $row['post_image'];
    //     }
    // }


    $query = "UPDATE users SET ";
    $query .= "user_firstname = '{$user_firstname}', ";
    $query .= "user_lastname = '{$user_lastname}', ";
    $query .= "user_role = '{$user_role}', ";
    $query .= "username = '{$username}', ";
    $query .= "user_email = '{$user_email}', ";
    $query .= "user_password = '{$user_password}' ";
    //$query .= "post_image = '{$post_image}' ";
    $query .= "WHERE username = '{$username}'";

    $update_user = mysqli_query($connection, $query);
    queryTest($update_user);
    header("Location: profile.php");
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
                            <input type="text" class="form-control" name="username" value="<?php echo $username ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_email">E-mail</label>
                            <input type="text" class="form-control" name="user_email" value="<?php echo $user_email ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input type="text" class="form-control" name="user_password" value="<?php echo $user_password ?>">
                        </div>
                        <!-- <div class="from-group">
        <label for="post_image">Image</label>
        <input type="file" name="post_image">
    </div> -->
                        <br>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="edit_user" value="Update Profile">
                        </div>
                    </form>

                    <!-- <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="index.html">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-file"></i> Blank Page
                        </li>
                    </ol> -->
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>