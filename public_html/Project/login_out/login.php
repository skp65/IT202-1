<?php
include("header.php");
?>

    <h4>Login to your Account</h4>
    <div class="wrapper">
        <form method="POST" name="form">
            <div>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" autocomplete="off" placeholder="Email" required/>
            </div>
            <div>
                <label for="p">Password</label><br>
                <input type="password" id="p" name="password" autocomplete="off" placeholder="Password" required/>
            </div>
            <div>
                <input class="submit" type="submit" name="login" value="Login"/>
            </div>
        </form>
    </div>
<?php
if (isset($_POST["login"])) {
    if (isset($_POST["password"]) && isset($_POST["email"])) {
        $password = $_POST["password"];
        $email = $_POST["email"];
        //require("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try {
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $stmt = $db->prepare("SELECT * FROM Users where email = :email LIMIT 1");
            $stmt->execute(array(
                ":email" => $email
            ));
            $e = $stmt->errorInfo();
            if ($e[0] != "00000") {
                echo var_export($e, true);
            } else {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    $rpassword = $result["password"];
                    if (password_verify($password, $rpassword)) {
                        echo "<div>Passwords matched! You are technically logged in!</div>";
                        $_SESSION["user"] = array(
                            "id" => $result["id"],
                            "first_name" => $result["first_name"]
                        );
                        echo var_export($_SESSION, true);
                        header("Location: shop.php");   //redirects to shop.php
                    } else {
                        echo "<div>Invalid password!</div>";
                    }
                } else {
                    echo "<div>Invalid user</div>";
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>