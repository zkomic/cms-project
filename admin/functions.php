<?php

function redirect($location)
{
    header("Location: " . $location);
    exit;
}

function usersOnline()
{
    if (isset($_GET['onlineUsers'])) {

        global $connection;
        if (!$connection) {

            session_start();
            include("../includes/db.php"); //zbog $connection

            $session = session_id();
            $time = time();

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $online_query = mysqli_query($connection, $query);
            queryTest($online_query);
            $online_count = mysqli_num_rows($online_query);

            if ($online_count == NULL) {

                mysqli_query($connection, "INSERT INTO users_online (session, time) VALUES ('$session', '$time')");
            } else {

                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }

            $time_out_inseconds = 30;
            $time_out = $time - $time_out_inseconds;
            $users_online = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
            echo $users_online_count = mysqli_num_rows($users_online);
        }
    } // get request 
}
usersOnline();

function queryTest($result)
{
    global $connection;
    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }
}

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
        echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this category?'); \" href='categories.php?delete={$cat_id}'>Delete</a></td>";
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
        redirect("categories.php");
    }
}

// Count * from table
function recordCount($table)
{
    global $connection;
    $query = "SELECT * FROM " . $table;
    $tableCount = mysqli_query($connection, $query);
    queryTest($tableCount);

    $result = mysqli_num_rows($tableCount);

    return $result;
}

// Count * from table WHERE
function recordSpecificCount($table, $column, $status)
{
    global $connection;
    $query = "SELECT * FROM " . $table . " WHERE " . $column . "='" . $status . "'";
    $tableCount = mysqli_query($connection, $query);
    queryTest($tableCount);

    $result = mysqli_num_rows($tableCount);

    return $result;
}

function isAdmin($username)
{
    global $connection;
    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $user = mysqli_query($connection, $query);
    queryTest($user);

    $row = mysqli_fetch_array($user);

    if ($row['user_role'] == 'admin') {

        return true;
    }
    return false;
}

function userLoggedNavigation($username)
{
    global $connection;

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
