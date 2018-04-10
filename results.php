<?php
	error_reporting(0);
	require_once("config.php");
	require_once("results.html");
	try{
		$connString = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
		$user = DBUSER;
		$pass = DBPASS;
		$count = 0;

		$pdo = new PDO($connString, $user, $pass);

		$name = $_POST["Type"];
		$location = $_POST["Location"];
		$allergen = $_POST["allergen"];
		
		$sql = "SELECT * FROM Restaurant WHERE ";

		if ($location != ""){
			if ($count == 0){
				$sql = $sql."Restaurant.City like '%$location%' ";
				$count++;
			}
			else{
				$sql = $sql."AND Restaurant.City like '%$location%' ";
				$count++;
			}
		}

		if ($name != ""){
			if ($count == 0){
				$sql = $sql."Restaurant.Name like '%$name%' OR Restaurant.Tags like '%$name%' ";
				$count++;
			}
			else{
				$sql = $sql."AND Restaurant.Name like '%$name%' OR Restaurant.Tags like '%$name%' ";
				$count++;
			}
		}

		if (!empty($allergen)){
			foreach ($allergen as &$value){
				if ($count == 0){
					$sql = $sql."Restaurant.Allergens like '%$value%' ";
					$count++;
				}
				else{
					$sql = $sql."AND Restaurant.Allergens like '%$value%' ";
					$count++;
				}
			}
		}

		$sql = $sql.";";


		$result = $pdo->query($sql);

		$count = $result->rowCount();


		while ($row=$result->fetch()){
		}

		$pdo = null;

		//header('Location: results.php');
	}
	catch(PDOException $e){
		print "Error!: ".$e->getMessage()."<br/>";
		die();
	}
?>
