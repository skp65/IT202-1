<form method="POST">
	<label for="email">Email
	<input type="email" id="email" name="email"/>
	</label>
	<label	for="pass">Password
	<input type="password" id="pass" name="password"/>
	</label>
	<label for="cpass">Confirm Password
	<input type="password" id="cpasss" name="cpassword"/>
	</label>
	<input type="submit" name="register" value="Register"/>
</form>

<?php
//echo var_export($_GET, true);
//echo var_export($_POST, true);
//echo var_export($_REQUEST, true);

if(isset($_POST["register"])){
	if(isset($_POST["password"]) && isset($_POST["cpassword"])){
		$password= $_POST["password'];
		$cpassword= $_POST["cpassword'];
		if($password == $cpassword){
			echo "<div>Passwords match</div>";
		}
		else{
			echo "<div>Passwords do not match</div>";
		}
	}
}
?>