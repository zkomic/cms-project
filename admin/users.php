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
                        Users

                        <?php

                        if (isset($_GET['source'])) {
                            $source = $_GET['source'];
                        } else {
                            $source = "";
                        }

                        switch ($source) {
                            case 'add_user';
                                include "includes/users_newUser.php";
                                break;

                            case 'edit_user';
                                include "includes/users_editUser.php";
                                break;

                            default:
                                include "includes/users_viewAll.php";
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