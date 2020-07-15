<?php
include_once(__DIR__."/partials/header.php");
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
                <input class="submit" type="submit" name="submit" value="Login"/>
                <input type="button" class="submit" onclick="window.location.href='changepwd.php'"
                       value="Change Password"/>
            </div>
        </form>
    </div>
<?php
if (Common::get($_POST, "submit", false)){
    $email = Common::get($_POST, "email", false);
    $password = Common::get($_POST, "password", false);
    if(!empty($email) && !empty($password)){
        $result = DBH::login($email, $password);
        echo var_export($result, true);
        if(Common::get($result, "status", 400) == 200){
            $_SESSION["user"] = Common::get($result, "data", NULL);
            die(header("Location: " . Common::url_for("home")));
        }
        else{
            Common::flash(Common::get($result, "message", "Error logging in"));
            die(header("Location: " . Common::url_for("login")));
        }
    }
    else{
        Common::flash("Email and password must not be empty", "warning");
        die(header("Location: " . Common::url_for("login")));
    }
}