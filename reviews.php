<?php
	error_reporting(0);
	require_once('config.php');
	
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	//$restaurant = "restaurant";
	//$review = "review";
	//$user = "user";
	
	$restId = $_GET['restaurantId'];
	
	$error = mysqli_connect_error();
	if($error != null){
		$output = "<p>Unable to connect to database</p>".$error;
		exit($output);
	}else{
		//do things
		//$sql0 = "SELECT * FROM " . $restaurant;
		//$sql1 = "SELECT * FROM " . $review;
		$sql0 = "SELECT * FROM `restaurant`, `review`, `user` WHERE restaurant.ID = review.RestaurantID AND user.UserID = review.UserID";
		$result0 = mysqli_query($conn,$sql0);
		//$result1 = mysqli_query($conn,$sql1);
		$entries = array();
		$rev = array();
		if($result0->num_rows > 0){
			while($row=$result0->fetch_assoc()){
				if($restId==$row["RestaurantID"]){
					$entries[] = array($row["FirstName"],$row["Zipcode"],$row["MainStars"],$row["AllergyStars"]); //,$row["Review"]); //review is too long to hold in an array
					$rev[]= array($row["Review"]);
					$restaurant = array($row["Name"],$row["Address"],$row["City"],$row["Phone"]);
				}
			}
		}
		//make user id and restaurant show the real names
		
	}
	mysqli_close($conn);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Reviews - Restaurant A</title> <!-- change Restaurant A to whatever the user searched for -->
	
	<style>
			#pos{
				position: relative;
			}
			body {
			font-size: .875rem;
			}

	/*
	* Sidebar
	*/

.sidebar {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 100; /* Behind the navbar */
  padding: 0;
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar-sticky {
  position: -webkit-sticky;
  position: sticky;
  top: 48px; /* Height of navbar */
  height: calc(100vh - 48px);
  padding-top: .5rem;
  overflow-x: hidden;
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
}

.sidebar .nav-link {
  font-weight: 500;
  color: #333;
}

.sidebar .nav-link .feather {
  margin-right: 4px;
  color: #999;
}

.sidebar .nav-link.active {
  color: #007bff;
}

.sidebar .nav-link:hover .feather,
.sidebar .nav-link.active .feather {
  color: inherit;
}

.sidebar-heading {
  font-size: .75rem;
  text-transform: uppercase;
}

	</style>
		
		<script type="text/javascript">
		//will need to get array info from database once we have that
		var restaurantList = [["User A","Back Bay",5,"What a cool place wow","Nut Free, No Soy"],["User B","Brookline",3,"Not as good as Burger King","No Dairy Free Alternatives, Peanut Free"]];
		var userList = <?php echo json_encode($entries); ?>; //user id, restaurant id, allergy stars
		var review = <?php echo json_encode($rev); ?>; 
		var restaurant = <?php echo json_encode($restaurant); ?>;
		//fix later to show the username rather than ID
		window.onload=function(){
			//sorting
			element = document.querySelectorAll("div.insert");
			for(var i=0; i<userList.length;i++){
				var frag = create('<div class="my-3 p-3 bg-white rounded box-shadow"><div class="media text-muted pt-3"><p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray"><strong class="d-block text-gray-dark"><a class="text-info user" style="font-size:1rem" href="#">a</a></strong><a class="text-dark city" href="#">b</a><br/><span class="main">c</span> <span class="allergy">d</span></br><a class="review" href="#">e</a></p></div></div>');
				element[0].parentElement.insertBefore(frag,element[0].childNodes[0]);
				
				
			}
			handleChange();
			
			function create(htmlStr) {
			var frag = document.createDocumentFragment(),
			temp = document.createElement('div');
			temp.innerHTML = htmlStr;
			while (temp.firstChild) {
				frag.appendChild(temp.firstChild);
			}
			return frag;
			}
			
			//insert restaurant info
			var name = document.getElementById("name");
			var address = document.getElementById("address");
			var phone = document.getElementById("phone");
			name.innerHTML = restaurant[0];
			address.innerHTML = restaurant[1] + ", " + restaurant[2];
			phone.innerHTML = restaurant[3];
		}
		
		function handleChange(){
			
			//input array data
			
			var users = document.getElementsByClassName("user");
			var cities = document.getElementsByClassName("city");
			var mains = document.getElementsByClassName("main");
			var reviews = document.getElementsByClassName("review");
			var allergies = document.getElementsByClassName("allergy");
			
			for(var i =0; i<userList.length;i++){
				users[i].innerHTML=userList[i][0];
				cities[i].innerHTML="Location: " + userList[i][1];
				allergies[i].innerHTML= "Allergy Review: " + userList[i][3] + " Stars";
				mains[i].innerHTML="Main Review: " + userList[i][2] + " Stars, ";
				reviews[i].innerHTML = review[i][0];
			}
			
		}
		
		</script>
  </head>
<body>
	<div class="d-flex flex-column flex-md-row bg-white border-bottom box-shadow">
	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-light p-2">
      <a class="navbar-brand" href="#"><img src="logo_long.png"/></a>

      <div class="navbar-collapse">
	  
        <ul class="navbar-nav px-3 mr-auto p-2">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-primary" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Username</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="#">Profile</a>
              <a class="dropdown-item" href="#">My Reviews</a>
              <a class="dropdown-item" href="#">Sign Out</a>
            </div>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" value="Restaurant A" id="search" aria-label="Search">
          <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>
	</div>
	
    <div class="container-fluid" id="pos">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
				<h3 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-5 mb-1 text-muted">
              <span id="name">Restaurant A</span>
				</h3>
				<a class="text-dark sidebar-heading d-flex px-3" id="address" href="#">Back Bay</a><br/> <!-- show maps on side maybe-->
				<span class="text-dark sidebar-heading d-flex px-3" id="phone">555-5555</span><br/>
				<p class="nav-link">
                  Description
                </p>
				<div class="px-2">
					This is a restaurant.
				</div>
            </div>
        </nav>
      </div>
    </div>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-5 px-4">

          <canvas class="my-4 chartjs-render-monitor" id="myChart" width="732" height="308" style="display: block; height: 5px; width: 586px;"></canvas>

          <h2>Reviews</h2> <br/> <button class="btn btn-outline-primary my-2 my-sm-0">Leave a Review</button>
		  
		  <div class="my-3 p-3 bg-white rounded box-shadow">
		  
        <div class="insert"></div>
		
      </div>
	  
     </main>
		
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>