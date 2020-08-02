<?php
include_once(__DIR__ . "/partials/header.php");

if (Common::is_logged_in()) {
    //this will auto redirect if user isn't logged in
}
?>
<div>
    <h3 style="text-align: center; color: darkorchid; font-weight: bold; font-size: 22px">
        Welcome to Way of the Food, <?php echo Common::get_username(); ?></h3>
</div>
<?php
$user = $_SESSION['user']['id'];
if ($user){
    $stmt = getDB()->prepare("select * from Users where id = '$user'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Your Profile:";
    $fname = $_SESSION['first_name'];
    $lname = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    echo "<b>Name: $fname . $lname</b>";
    echo "<b>Email: $email</b>";
}
?>