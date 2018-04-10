<?php
require_once("config.php");
require_once("addreview.html");
	try{
		$connString = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
		$user = DBUSER;
		$pass = DBPASS;
		$max = 0;

		$pdo = new PDO($connString, $user, $pass);

		$restaurant = $_GET['restaurant'];


	}
	catch(PDOException $e){
		print "Error!: ".$e->getMessage()."<br/>";
		die();
	}
?>
