<?php session_start(); ?>
<?php include "db.php"; ?>
<?php include "functions.php"; ?>

<?php

if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    userLogin($username, $password);
}
