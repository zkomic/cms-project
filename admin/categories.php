<?php include "includes/admin_header.php" ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>


    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin
                        <small>Author</small>
                    </h1>

                    <div class="col-xs-6">

                        <?php

                        if (isset($_POST['submit'])) {

                            $cat_title = $_POST['cat_title'];

                            if ($cat_title == "" || empty($cat_title)) { //empty string OR empty
                                echo "<div class='alert alert-danger' role='alert'>";
                                echo "This field should not be empty.";
                                echo "</div>";
                            } else {

                                $query = "INSERT INTO categories(cat_title) ";
                                $query .= "VALUE('{$cat_title}')";

                                $new_category_query = mysqli_query($connection, $query);

                                if (!$new_category_query) {

                                    die("Query failed!" . mysqli_error($connection));
                                }
                            }
                        }

                        ?>

                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat-title">New Category</label>
                                <input class="form-control" type="text" name="cat_title">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                            </div>
                        </form>
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

                                <?php 
                                //FIND ALL CATEGORIES

                                $query = "SELECT * FROM categories";
                                //$query = "SELECT * FROM categories LIMIT 2";
                                $categories = mysqli_query($connection, $query);

                                while ($row = mysqli_fetch_assoc($categories)) {

                                    $cat_id = $row['cat_id'];
                                    $cat_title = $row['cat_title'];
                                    echo "<tr>";
                                    echo "<td>{$cat_id}</td>";
                                    echo "<td>{$cat_title}</td>";
                                    echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
                                    echo "</tr>";
                                }
                                ?>

                                <?php 
                                // DELETE CATEGORY

                                if (isset($_GET['delete'])) {

                                    $delete_cat_id = $_GET['delete'];

                                    $query = "DELETE FROM categories WHERE cat_id = {$delete_cat_id}";
                                    $delete_category = mysqli_query($connection, $query);
                                    header("Location: categories.php"); //page refresh after deleting
                                }

                                ?>

                            </tbody>
                        </table>
                    </div>
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