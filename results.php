<?php
	require_once("config.php");
	require_once("results.html");
	try{
		$connString = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
		$user = DBUSER;
		$pass = DBPASS;
		$count = 0;

		$pdo = new PDO($connString, $user, $pass);

		$name = $_POST["Type"];
		$keyword = $_POST["Keyword"];
		$location = $_POST["Location"];
		$allergen = $_POST["allergen"];

		echo var_dump($allergen);
		
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
				$sql = $sql."Restaurant.Name like '%$ name%' ";
				$count++;
			}
			else{
				$sql = $sql."AND Restaurant.Name like '%$name%' ";
				$count++;
			}
		}

		if ($keyword != ""){
			if ($count == 0){
				$sql = $sql."Restaurant.Tags like '%$keyword%' ";
				$count++;
			}
			else{
				$sql = $sql."AND Restaurant.Tags like '%$keyword%' ";
				$count++;
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
