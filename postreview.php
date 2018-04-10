<?php
require_once("config.php");
	try{
		$connString = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
		$user = DBUSER;
		$pass = DBPASS;
		$max = 0;

		$pdo = new PDO($connString, $user, $pass);

		$overAllStars = $_POST['Ostar'];
		$allergyStars = $_POST['Astar'];
		$text = $_POST['AllergyText'];
		$restaurant = $_GET['restaurant'];

		$sqlRestaurant = "SELECT Restaurant.ID FROM Restaurant WHERE Restaurant.Name like '%$restaurant%';";

		$sqlUser = "SELECT User.UserID FROM User WHERE User.Email like '%efindlaywalters@gmail.com%';";

		$resultRestaurant = $pdo->query($sqlRestaurant);
		$resultUser = $pdo->query($sqlUser);

		$rowRestaurant = $resultRestaurant->fetch();
		$rowUser = $resultUser->fetch();

		$sqlReview = "SELECT Review.ReviewID FROM Review";

		$resultReview = $pdo->query($sqlReview);

		while($row = $resultReview->fetch()){
			if ($row[0] >  $max){
				$max = $row['ReviewID'];
			}
		}

		$max = $max + 1;

		$userID = $rowUser['UserID'];
		$restaurantID = $rowRestaurant['ID'];

		echo $max." ".$restaurantID." ".$userID." ".$overAllStars." ".$allergyStars." ".$text;

		$sqlInsert = "INSERT INTO `Review`(`ReviewID`, `RestaurantID`, `UserID`, `MainStars`, `AllergyStars`, `Review`) VALUES ('$max','$restaurantID','$userID','$overAllStars','$allergyStars','$text')";

		$result = $pdo->query($sqlInsert);

		$pdo=null;


		header('Location: reviews.php?restaurant='.$restaurant);

	}
	catch(PDOException $e){
		print "Error!: ".$e->getMessage()."<br/>";
		die();
	}
?>
