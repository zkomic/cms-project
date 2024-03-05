<?php

if (isset($_POST['login'])) {

    if (isset($_POST['username']) && isset($_POST['password'])) {

        userLogin($_POST['username'], $_POST['password']);
    } else {

        redirect("index");
    }
}

?>

<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="/cms-project/search" method="post">
            <div class="input-group">
                <input type="text" name="search" class="form-control" required>
                <span class="input-group-btn">
                    <button class="btn btn-default" name="submit" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>

    <?php



    if (!isset($_SESSION['username'])) {

    ?>

        <!-- Login -->
        <div class="well">
            <h4>Login</h4>
            <form method="post">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="login" type="submit">
                            <span>Login</span>
                        </button>
                    </span>
                </div>
                <div class="form-group">
                    <a href="forgotPassword.php?forgot=<?php echo uniqid(true); ?>">Forgot your password?</a>
                </div>
            </form>
            <!-- /.input-group -->
        </div>

    <?php
    }

    ?>



    <!-- Blog Categories Well -->

    <?php

    $query = "SELECT * FROM categories";
    //$query = "SELECT * FROM categories LIMIT 2";
    $categories = mysqli_query($connection, $query);

    ?>

    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled">

                    <?php

                    while ($row = mysqli_fetch_assoc($categories)) {

                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];
                        echo "<li><a href='/cms-project/category/$cat_id'>{$cat_title}</a></li>";
                    }
                    ?>

                </ul>
            </div>
            <!-- /.col-lg-6 -->
            <div class="col-lg-6">
                <ul class="list-unstyled">
                    <!-- <li><a href="#">Category Name</a>
                    </li>
                    <li><a href="#">Category Name</a>
                    </li>
                    <li><a href="#">Category Name</a>
                    </li>
                    <li><a href="#">Category Name</a>
                    </li> -->
                </ul>
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "widget.php" ?>

</div>