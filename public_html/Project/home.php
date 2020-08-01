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
$id = $_SESSION["user"]["id"];
$stmt = getDB()->prepare("SELECT * FROM Users where id = '$id'");
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

while ($result) {
    ?>
    <div>Your Profile</div>
    <table>
        <tr>
            <td>
                <div>Your name:</div>
            </td>
            <td>
                <?php echo$result['fname']?> <?php echo$result['lname']?>
            </td>
            <td>
                <div>Your Email address:</div>
            </td>
            <td>
                <?php echo$result['email']?>
            </td>
        </tr>
    </table>
    <?php
}
?>

