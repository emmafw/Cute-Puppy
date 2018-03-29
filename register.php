<?php
	require_once("config.php");

	try{
	
		$connString = "mysql:host=".DBHOST.";dbname=".DBNAME;
		$user = DBUSER;
		$pass = DBPASS;
		$max = 0;

		$pdo = new PDO($connString, $user, $pass);

		$sql1 = "SELECT UserID FROM User";

		$result1 = $pdo->query($sql1);

		while($row = $result1->fetch()){
			if ($row['UserID'] >  $max){
				$max = $row['UserID'];
			}
		}

		$UserID = $max + 1;
		
		$firstName = $_POST["firstName"];
		$lastName = $_POST["lastName"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$password = md5($password);
		$zip = $_POST["zip"];
		$allergy = $_POST["allergy"];

		$sql2 = "INSERT INTO `User`(`UserID`, `FirstName`, `LastName`, `Email`, `Zipcode`, `Password`, `Allergy`) VALUES ('$UserID', '$firstName', '$lastName', '$email', '$zip', '$password', '$allergy')";
		$result2 = $pdo->query($sql2);
		$pdo = null;
	}
	catch(PDOException $e){
		print "Error!: ".$e->getMessage()."<br/>";
		die();
	}

?>
