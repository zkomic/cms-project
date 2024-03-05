<?php

function queryTest($result)
{
    global $connection;
    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }
}

function redirect($location)
{
    header("Location: " . $location);
    exit;
}

function ifMethod($method = null)
{
    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    }
    return false;
}

function isLoggedIn()
{
    if (isset($_SESSION['username'])) {
        return true;
    }
    return false;
}

function usernameExists($username)
{
    global $connection;

    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    queryTest($result);

    if (mysqli_num_rows($result) > 0) {

        return true;
    } else {

        return false;
    }
}

function emailExists($email)
{
    global $connection;

    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    queryTest($result);

    if (mysqli_num_rows($result) > 0) {

        return true;
    } else {

        return false;
    }
}

function userRegistration($username, $email, $password)
{
    global $connection;

    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    // https://www.php.net/manual/en/function.password-hash.php
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

    $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
    $query .= "VALUES ('{$username}', '{$email}', '{$password}', 'subscriber')";
    $register_user = mysqli_query($connection, $query);
    queryTest($register_user);

    $_SESSION['username'] = $username;
}

function userLogin($username, $password)
{
    global $connection;

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $login_user = mysqli_query($connection, $query);
    queryTest($login_user);

    while ($row = mysqli_fetch_assoc($login_user)) {

        //$db_id = $row['user_id'];
        $db_firstname = $row['user_firstname'];
        $db_lastname = $row['user_lastname'];
        $db_username = $row['username'];
        $db_password = $row['user_password'];
        $db_role = $row['user_role'];

        // https://www.php.net/manual/en/function.password-verify.php
        if (password_verify($password, $db_password)) {

            $_SESSION['username'] = $db_username;
            $_SESSION['firstname'] = $db_firstname;
            $_SESSION['lastname'] = $db_lastname;
            $_SESSION['role'] = $db_role;

            redirect("/cms-project/admin");
        } else {
            return false;
        }
    }
    return true;
}

function userLoggedNavigation($username)
{
    global $connection;

    $username = $_SESSION['username'];
    $query = "SELECT user_firstname, user_lastname FROM users WHERE username = '$username'";
    $logged_user = mysqli_query($connection, $query);
    queryTest($logged_user);

    while ($row = mysqli_fetch_assoc($logged_user)) {

        $firstname = $row['user_firstname'];
        $lastname = $row['user_lastname'];
        if (!empty($username) && !empty($lastname)) {

            echo "<a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-user'></i>&nbsp;&nbsp; $firstname $lastname <b class='caret'></b></a>";
        } else {

            echo "<a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-user'></i>&nbsp;&nbsp; $username <b class='caret'></b></a>";
        }
    }
}
