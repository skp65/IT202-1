<?php
include_once(__DIR__ . "/partials/header.php");
?>
    <div>
        <h3 style="text-align: center; color: darkorchid; font-weight: bold; font-size: 22px">
            Welcome to Way of the Food, <?php echo Common::get_username(); ?></h3>
    </div>

<?php
if (Common::is_logged_in()) {
    //this will auto redirect if user isn't logged in
}

$stmt = getDB()->prepare("SELECT * FROM Users where email = 'email'");
$stmt->execute();

while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <div>Your Profile</div>
    <table>
        <tr>
            <td>
                <div>Your name:</div>
            </td>
            <td>
                <?php echo $result['fname'] ?><?php echo $result['lname'] ?>
            </td>
            <td>
                <div>Your Email address:</div>
            </td>
            <td>
                <?php echo $result['email'] ?>
            </td>
        </tr>
    </table>
    <?php
}
?>

