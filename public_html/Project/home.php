<?php
include_once(__DIR__."/partials/header.php");
if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
}
?>
<div>
    <p>Welcome, <?php echo Common::get_username();?></p>
</div>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<style>
    body {
        background-image: url('/images/1.jpg');
    }
</style>


