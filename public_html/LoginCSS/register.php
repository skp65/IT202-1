<?php
include("header.php");
?>
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
	if(isset($_POST["password"]) && isset($_POST["cpassword"]) && isset($_POST["email"])){
		$password= $_POST["password"];
		$cpassword= $_POST["cpassword"];
		$email = $_POST["email"];
		if($password == $cpassword){
			//echo "<div>Passwords match</div>";
			//require("config.php");
			$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
			try{
				$db = new PDO($connection_string, $dbuser, $dbpass);
				$hash = password_hash($password, PASSWORD_BCRYPT);
				$stmt = $db->prepare("INSERT INTO Users (email, password) VALUES(:email, :password)");
				$stmt->execute(array(
					":email" => $email,
					":password" => $hash //Don't save the raw password $password
				));
				$e = $stmt->errorInfo();
				if ($e[0] != "00000"){
						echo var_export($e, true);
				}
				else{
					echo "<div>Successfully registered! </div>";
				}
			}
			catch (Exception $e){
				echo $e->getMessage();
			}
		}
		else{
			echo "<div>Passwords do not match</div>";
		}
	}
}
?>