<?php
include("header.php");
?>

    <div class="wrapper">
        <form method="POST">
            <div>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" placeholder="Email" required/>
            </div>
            <div>
                <label for="pass">New Password</label><br>
                <input type="password" id="pass" name="password" placeholder="Password" required/>
            </div>
            <div>
                <label for="cpass">Confirm New Password</label><br>
                <input type="password" id="cpasss" name="cpassword" placeholder="Confirm New Password" required/>
            </div>
            <div>
                <input class="submit" type="submit" name="register" value="Change Password"/>
                <input type="button" class="submit"
                       onclick="window.location.href='https://it202-2020.herokuapp.com/public_html/Project/login_out/login.php'"
                       value="Go to Login"/>
            </div>
        </form>
    </div>
<?php
//echo var_export($_GET, true);
//echo var_export($_POST, true);
//echo var_export($_REQUEST, true);

if (isset($_POST["register"])) {
    if (isset($_POST["password"]) && isset($_POST["cpassword"]) && isset($_POST["email"])) {
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        $email = $_POST["email"];
        if ($password == $cpassword) {
            //echo "<div>Passwords match</div>";
            //require("config.php");
            try {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $stmt = getDB()->prepare("UPDATE Users set password = :password where email = :email");
                $stmt->execute(array(
                    ":email" => $email,
                    ":password" => $hash //Don't save the raw password $password
                ));
                $e = $stmt->errorInfo();
                if ($e[0] != "00000") {
                    echo var_export($e, true);
                } else {
                    echo "<div>Password Changed! </div>";
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        } else {
            echo "<div>Passwords do not match</div>";
        }
    }
}
?>