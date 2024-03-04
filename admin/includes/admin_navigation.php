<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">CMS Admin</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li>
            <!--<a href="#"><i class="fa fa-circle" style="color: #63E6BE;"></i>&nbsp;Online Users: <?php echo usersOnline(); ?></a>-->
            <a href="#"><i class="fa fa-circle" style="color: #63E6BE;"></i>&nbsp;Online Users: <span class="usersOnline"></span></a>
        </li>
        <li><a href="../index.php">Home Page</a></li>
        <li class="dropdown">

            <?php

            if (isset($_SESSION['username'])) {

                $username = $_SESSION['username'];
                $query = "SELECT * FROM users WHERE username = '{$username}'";
                $logged_user = mysqli_query($connection, $query);
                queryTest($logged_user);

                while ($row = mysqli_fetch_assoc($logged_user)) {

                    $firstname = $row['user_firstname'];
                    $lastname = $row['user_lastname'];
                }

                if (!empty($firstname) && !empty($lastname)) {

                    echo "<a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-user'></i> $firstname $lastname <b class='caret'></b></a>";
                } else {

                    echo "<a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-user'></i> $username <b class='caret'></b></a>";
                }
            }

            ?>

            <ul class="dropdown-menu">
                <li>
                    <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts">
                    <i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i>
                </a>
                <ul id="posts" class="collapse">
                    <li>
                        <a href="./posts.php">All Posts</a>
                    </li>
                    <li>
                        <a href="./posts.php?source=add_post">New Post</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="./categories.php"><i class="fa fa-fw fa-wrench"></i> Categories </a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo">
                    <i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i>
                </a>
                <ul id="demo" class="collapse">
                    <li>
                        <a href="users.php">All Users</a>
                    </li>
                    <li>
                        <a href="users.php?source=add_user">New User</a>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="comments.php"><i class="fa fa-fw fa-file"></i> Comments </a>
            </li>
            <li>
                <a href="profile.php"><i class="fa fa-fw fa-dashboard"></i> Profile </a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>