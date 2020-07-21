<?php
include_once(__DIR__."/partials/header.php");
?>
    <h4>Register your Account</h4>
    <div class="wrapper">
        <form method="POST">
            <div>
                <label for="fname">First Name</label><br>
                <input type="text" id="fname" name="fname" placeholder="First Name" required/>
            </div>
            <div>
                <label for="lname">Last Name</label><br>
                <input type="text" id="lname" name="lname" placeholder="Last Name" required/>
            </div>
            <div>
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email" placeholder="Email" required/>
            </div>
            <div>
                <label for="pass">Password</label><br>
                <input type="password" id="pass" name="password" placeholder="Password"/>
            </div>
            <div>
                <label for="cpass">Confirm Password</label><br>
                <input type="password" id="cpasss" name="cpassword" placeholder="Confirm Password"/>
            </div>
            <div>
                <input class="submit" type="submit" name="submit" value="Register"/>
            </div>
        </form>
    </div>
<?php
if (Common::get($_POST, "submit", false)){
    $email = Common::get($_POST, "email", false);
    $fname = Common::get($_POST, "fname", false);
    $lname = Common::get($_POST, "lname", false);
    $password = Common::get($_POST, "password", false);
    $confirm_password = Common::get($_POST, "cpassword", false);
    if($password != $confirm_password){
        Common::flash("Passwords must match", "warning");
        die(header("Location: register.php"));
    }
    if(!empty($email) && !empty($fname) && !empty($lname) && !empty($password)){
        $result = DBH::register($email, $fname, $lname, $password);
        echo var_export($result, true);
        if(Common::get($result, "status", 400) == 200){
            echo "<div style='text-align: center'>Successfully Registered, Please Login</div>";
            die(header("Location: " . Common::url_for("login")));
        }
    }
    else{
        echo "<div style='text-align: center'>Email and Password must not be empty!</div>";
        die(header("Location: register.php"));
    }
}