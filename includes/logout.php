<?php include "db.php"; ?>
<?php include "functions.php"; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php

// canceling session
$_SESSION['username'] = null;
$_SESSION['firstname'] = null;
$_SESSION['lastname'] = null;
$_SESSION['role'] = null;

header("Location: ../index.php");
