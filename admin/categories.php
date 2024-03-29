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
                        Categories
                    </h1>
                    <div class="col-xs-6">

                        <?php newCategory(); ?>

                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat-title">New Category</label>
                                <input class="form-control" type="text" name="cat_title">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                            </div>
                        </form>

                        <?php
                        // EDIT CATEGORY INCLUDE

                        if (isset($_GET['edit'])) {

                            $cat_id = $_GET['edit'];
                            include "includes/category_edit.php";
                        }

                        ?>

                    </div>
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Title</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php findAllCategories(); ?>
                                <?php deleteCategory(); ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>