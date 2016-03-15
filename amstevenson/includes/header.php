<!DOCTYPE HTML>

<html>
<head>
    <title><?php echo $pageTitle ?></title>
    <meta name="author" content="Adam Stevenson">
    <meta name="description" content="<?php echo $metaDescription ?>">
    <meta name="keywords" content="Website Development, .NET, PhP, Java, C#, C++, Android, Cuda, Software Engineering, Databases">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lte IE 8]>
    <script src="../js/ie/shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="../style/main.css" />
    <!--[if lte IE 9]>
    <link rel="stylesheet" href="../style/ie9.css"/><![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="../style/ie8.css"/><![endif]-->
    <link rel="stylesheet" type="text/css" href="../style/sweetalert.css">
</head>
<body>

<!-- Page Wrapper -->
<div id="page-wrapper">

    <!-- Header -->
    <header id="header" class="alt">
        <h1><a href="index.php">Adam Stevenson</a></h1>
        <nav>
            <a href="#menu">Menu</a>
        </nav>
    </header>

    <!-- Menu -->
    <nav id="menu">
        <div class="inner">
            <h2>Menu</h2>
            <ul class="links">
                <li><a href="../index.php">Home</a></li>
                <li><a href="../projectgallery.php">Projects</a></li>
                <li><a href="../blogs.php">Blog</a></li>

                <?php

                    if($loggedIn)
                    {
                        echo '  <li><a href="../admin/adminindex.php">Blog Dashboard</a></li> ';
                        if($user->is_user_admin())
                            echo '  <li><a href="../admin/users.php">Blog Users</a></li> ';

                        echo '  <li><a href="../index.php?logout=true">Logout</a></li> ';
                    }
                    else
                    {
                        echo '  <li><a href="../admin/adduser.php">Register</a></li> ';
                        echo '  <li><a href="../admin/login.php">Login</a></li> ';
                    }
                ?>
            </ul>
            <a href="#" class="close">Close</a>
        </div>
    </nav>