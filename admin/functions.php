<?php

function findAllCategories()
{

    global $connection;
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
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}

function newCategory()
{

    global $connection;
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
}

function deleteCategory()
{

    global $connection;
    if (isset($_GET['delete'])) {

        $delete_cat_id = $_GET['delete'];

        $query = "DELETE FROM categories WHERE cat_id = {$delete_cat_id}";
        $delete_category = mysqli_query($connection, $query);
        header("Location: categories.php"); //page refresh after deleting
    }
}
