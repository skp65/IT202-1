<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<nav>
    <ul class="head">
        <li><a href="home.php">Home</a></li>
        <li><a href="shop.php">Products</a></li>
        <li><a href="sort.php">Search Products</a></li>
        <li><a href="logout.php">Logout</a></li>
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