<?php include "includes/admin_header.php" ?>

<?php

if (!isAdmin($_SESSION['username'])) {

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
                        Posts

                        <?php

                        if (isset($_GET['source'])) {
                            $source = $_GET['source'];
                        } else {
                            $source = "";
                        }

                        switch ($source) {
                            case 'add_post';
                                include "includes/posts_newPost.php";
                                break;

                            case 'edit_post';
                                include "includes/posts_editPost.php";
                                break;

                            default:
                                include "includes/posts_viewAll.php";
                                break;
                        }

                        ?>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>