<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<nav>
    <ul class="nav">
        <li><a href="login_out/shop.php">Shop</a></li>
        <li><a href="login_out/register.php">Sign Up</a></li>
        <li><a href="login_out/login.php">Login</a></li>
        <li><a href="login_out/logout.php">Logout</a></li>
    </ul>
</nav>
<style>
    body {
        background-image: url('images/1.jpg');
    }
</style>
<?php
require("common.inc.php");
session_start();
?>