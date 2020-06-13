<?php
include("header.php");
?>
    <div class="wrapper">
        <form action="login.php" method="POST">
            <div>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" placeholder="Email" required/>
            </div>
            <div>
                <label for="pass">Password</label><br>
                <input type="password" id="pass" name="password" placeholder="Password" required/>
            </div>
            <div>
                <label for="cpass">Confirm Password</label><br>
                <input type="password" id="cpasss" name="cpassword" placeholder="Confirm Password" required/>
            </div>
            <div>
                <input class="submit" type="submit" name="register" value="Register"/>
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
            $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
            try {
                $db = new PDO($connection_string, $dbuser, $dbpass);
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $db->prepare("INSERT INTO Users (email, password) VALUES(:email, :password)");
                $stmt->execute(array(
                    ":email" => $email,
                    ":password" => $hash //Don't save the raw password $password
                ));
                $e = $stmt->errorInfo();
                if ($e[0] != "00000") {
                    echo var_export($e, true);
                } else {
                    echo "<div>Successfully registered! </div>";
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