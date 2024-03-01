<?php include "db.php"; ?>
<?php include "functions.php"; ?>
<?php session_start(); ?>
<?php

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $login_user = mysqli_query($connection, $query);
    queryTest($login_user);

    while ($row = mysqli_fetch_assoc($login_user)) {

        $db_id = $row['user_id'];
        echo $db_firstname = $row['user_firstname'];
        $db_lastname = $row['user_lastname'];
        $db_username = $row['username'];
        echo $db_password = $row['user_password'];
        $db_role = $row['user_role'];
    }

    // https://www.php.net/manual/en/function.password-verify.php
    if (password_verify($password, $db_password)) {

        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_firstname;
        $_SESSION['lastname'] = $db_lastname;
        $_SESSION['role'] = $db_role;

        header("Location: ../admin");
    }
    else {
        header("Location: ../index.php");
    }
}
