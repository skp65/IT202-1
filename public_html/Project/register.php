<?php
include_once(__DIR__."/partials/header.php");
?>
    <head>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <style>
        body {
            background-image: url('/images/1.jpg');
        }
    </style>

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
                <input type="password" id="pass" name="password" placeholder="Password" required/>
            </div>
            <div>
                <label for="cpass">Confirm Password</label><br>
                <input type="password" id="cpasss" name="cpassword" placeholder="Confirm Password" required/>
            </div>
            <div>
                <input class="submit" type="submit" name="submit" value="Register"/>
            </div>
        </form>
    </div>
<?php
if (Common::get($_POST, "submit", false)){
    $email = Common::get($_POST, "email", false);
    $password = Common::get($_POST, "password", false);
    $confirm_password = Common::get($_POST, "cpassword", false);
    if($password != $confirm_password){
        Common::flash("Passwords must match", "warning");
        die(header("Location: register.php"));
    }
    if(!empty($email) && !empty($password)){
        $result = DBH::register($email, $password);
        echo var_export($result, true);
        if(Common::get($result, "status", 400) == 200){
            Common::flash("Successfully registered, please login", "success");
            die(header("Location: " . Common::url_for("login")));
        }
    }
    else{
        Common::flash("Email and password must not be empty", "warning");
        die(header("Location: register.php"));
    }
}