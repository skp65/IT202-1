<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<nav>
    <ul class="nav">
        <li><a href="home.php">Home</a></li>
        <li><a href="register.php">Sign Up</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>
<style>
    body {
        background-image: url('images/1.jpg');
    }
</style>
<?php
require("config.php");
session_start();
?>