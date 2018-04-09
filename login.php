<?php
	require_once("config.php");

	try{
		$connString = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
		$user = DBUSER;
		$pass = DBPASS;

		$pdo = new PDO($connString, $user, $pass);

		$email = $_POST["Email"];
		$password = $_POST["password"];

		$password = md5($password);

		$sql = "SELECT * FROM User WHERE User.Email like '$email' AND User.Password like '$password';";

		$result = $pdo->query($sql);

		$count = $result->rowCount();

		if ($count == 0){
			print "No user with that email password combo";
		}
		else{
			print "Successfully logged in";
		}

		$pdo = null;

		header('Location: foodlergy.html');
	}
	catch(PDOException $e){
		print "Error!: ".$e->getMessage()."<br/>";
		die();
	}
?>
