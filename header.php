<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boossto Task</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>

<body>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="logout.php" class="nav-link"><?php echo isset($_SESSION['authenticated']) ? 'Logout' : '' ?></a>
            </li>
            <li class="nav-item">
                <a href="admin_panel.php" class="nav-link"><?php echo isset($_SESSION['authenticated']) && $_SESSION['role_id'] == 1 ? 'All Posts' : '' ?></a>
            </li>
            <li class="nav-item">
                <a href="index.php" class="nav-link"><?php echo isset($_SESSION['authenticated']) ? 'News Feed' : '' ?></a>
            </li>
            <li class="nav-item">
                <a href="all_users.php" class="nav-link"><?php echo isset($_SESSION['authenticated']) && $_SESSION['role_id'] == 1 ? 'All Users' : '' ?></a>
            </li>
            <li class="nav-item">
                <a href="login.php" class="nav-link"><?php echo !isset($_SESSION['authenticated']) ? 'Login' : '' ?></a>
            </li>
            <li class="nav-item">
                <a href="register_user.php" class="nav-link"><?php echo !isset($_SESSION['authenticated']) ? 'Sign Up' : '' ?></a>
            </li>
        </ul>
    </nav>