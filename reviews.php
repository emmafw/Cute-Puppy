<?php
	require_once("config.php");
	require_once("reviews.html");
	try{
		$connString = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
		$user = DBUSER;
		$pass = DBPASS;
		$count = 0;

		$pdo = new PDO($connString, $user, $pass);

		$Restaurant = $_GET['restaurant'];
		
		$sql = "SELECT * FROM Restaurant INNER JOIN Review ON Restaurant.ID = Review.RestaurantID WHERE Restaurant.Name like '%$Restaurant%' ORDER BY Review.ReviewID DESC;";

		$result = $pdo->query($sql);

		$count = $result->rowCount();


		while ($row=$result->fetch()){
			$city = $row[4];
			$state = $row[5];
		}

		$pdo = null;

	}
	catch(PDOException $e){
		print "Error!: ".$e->getMessage()."<br/>";
		die();
	}
?>
