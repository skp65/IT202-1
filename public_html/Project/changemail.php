<?php
include_once(__DIR__ . "/partials/header.php");
?>
    <div class="wrapper">
        <form method="POST">
            <div>
                <label for="email">Current Email</label><br>
                <input type="email" id="cemail" name="cemail" placeholder="Current Email" required/>
            </div>
            <div>
                <label for="email">New Email</label><br>
                <input type="email" id="email" name="email" placeholder="New Email" required/>
            </div>
            <div>
                <input class="submit" type="submit" name="update" value="Change Email"/>
                <input type="button" class="submit"
                       onclick="window.location.href='login.php'"
                       value="Login"/>
            </div>
        </form>
    </div>
<?php
if (isset($_POST["update"])) {
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $cemail = $_POST["cemail"];
        $id = $_GET["id"];
        require("common.inc.php");
        try {
            $stmt = getDB()->prepare("SELECT email FROM Users where id = :id  ");
            $stmt->execute(array(
                ":email" => $email,
                ":id" => $id
            ));
            if ($cemail != $email) {
                if ($stmt->rowCount()> 0){
                    echo "<b><div style='text-align: center'>Email exists! Use another Email</div></b>";
                }
                else {
                    $query = getDB()->prepare("UPDATE Users set email = :email where email = :cemail");
                    $query->execute(array(":email" => $email,
                        ":cemail" => $cemail
                    ));
                    echo "<b><div style='text-align: center'>Email Changed!</div></b>";
                }
            }
            else{
                echo"<b>Error Changing email.</b>";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } else {
        echo "<b><div style='text-align: center'>Error Changing email </div></b>";
    }
}
?>