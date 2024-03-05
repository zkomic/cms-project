<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">CMS Home</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <?php

                $query = "SELECT * FROM categories";
                $categories = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($categories)) {

                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    $category_class = '';
                    $registration_class = '';
                    $contact_class = '';
                    $page_name = basename($_SERVER['PHP_SELF']);
                    $registration = 'registration.php';
                    $contact = 'contact.php';

                    if (isset($_GET['category']) && $_GET['category'] == $cat_id) {
                        $category_class = 'active';
                    } else if ($page_name == $registration) {
                        $registration_class = 'active';
                    } else if ($page_name == $contact) {
                        $contact_class = 'active';
                    }

                    echo "<li class='$category_class' ><a href='category.php?category={$cat_id}'>{$cat_title}</a></li>";
                }

                ?>

                <li class="<?php echo $contact_class ?>">
                    <a href="contact.php">Contact</a>
                </li>

            </ul>
            <ul class="nav navbar-nav navbar-right">

                <?php

                if (isset($_SESSION['role'])) {

                    if (isset($_GET['p_id'])) {

                        $p_id = $_GET['p_id'];

                        echo "<li><a href='admin/posts.php?source=edit_post&p_id={$p_id}'>Edit Post</a></li>";
                    }
                }

                ?>

                <?php

                if (!isset($_SESSION['username'])) {

                    echo "<li class='$registration_class'><a href='registration.php'>Registration</a></li>";
                } else {

                ?>

                    <li><a href='admin'>Admin</a></li>
                    <li class="dropdown">

                        <?php

                        userLogged($_SESSION['username']);

                        ?>
                        
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#"><i class="fa fa-fw fa-user"></i>&nbsp;Profile</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="includes/logout.php"><i class="fa fa-fw fa-power-off"></i>&nbsp;Log Out</a>
                            </li>
                        </ul>
                    </li>

                    <?php


                    ?>


                <?php

                }

                ?>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>