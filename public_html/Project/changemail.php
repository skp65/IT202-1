<?php
include_once(__DIR__ . "/partials/header.php");
?>
    <div class="wrapper">
        <form method="POST">
            <div>
                <label for="email">New Email</label><br>
                <input type="email" id="email" name="email" placeholder="New Email" required/>
            </div>
            <div>
                <input class="submit" type="submit" name="register" value="Change Email"/>
                <input type="button" class="submit"
                       onclick="window.location.href='login.php'"
                       value="Login"/>
            </div>
        </form>
    </div>
<?php
if (isset($_POST["register"])) {
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        require("common.inc.php");
        try {
            $stmt = getDB()->prepare("SELECT * FROM Users where email = :email LIMIT 1");
            $stmt->execute(array(
                ":email" => $email
            ));
            if ($stmt->rowCount() > 0) {
                $error = "Email already exists.";
            } else {
                $result = getDB()->prepare("Update Users set email = :email where email = :email")
                    echo "<div style='text-align: center'>Email Changed! </div>";
                }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>