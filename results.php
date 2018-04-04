<?php
	error_reporting(0);
	require_once('config.php');
	
	$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	$restaurant = "restaurant";
	$review = "review";
	$user = "user";
	
	$error = mysqli_connect_error();
	if($error != null){
		$output = "<p>Unable to connect to database</p>".$error;
		exit($output);
	}else{
		//do things
		$sql0 = "SELECT * FROM " . $restaurant;
		$sql1 = "SELECT * FROM " . $review;
		$sql2 = "SELECT * FROM " . $user;
		$result0 = mysqli_query($conn,$sql0);
		$result1 = mysqli_query($conn,$sql1);
		$result2 = mysqli_query($conn,$sql2);
		$entries = array();
		if($result0->num_rows > 0){
			$i=0;
			while($row=$result0->fetch_assoc()){
				$entries[$i] = array($row["Name"],$row["City"],$row["Tags"],$row["ID"]);
				$i=$i+1;
			}
		}else{
		}
		
		if($result1->num_rows>0){
			$temp = array();
			while($row1=$result1->fetch_assoc()){
				$id = $row1["RestaurantID"];
				if($temp[$id-1]==null){
					$temp[$id-1] = array();
				}
				
				array_push($temp[$id-1],$row1["MainStars"]);
			}
			for($i=0;$i<count($temp);$i=$i+1){
				$num_reviews = count($temp[$i]);
				$avg = array_sum($temp[$i])/$num_reviews;
				array_push($entries[$i],$num_reviews,$avg);
			}
		}
		
		if($result2->num_rows>0){
			while($row2=$result2->fetch_assoc()){
				$allergen = array($row2["Allergy"]); //later change so that it only takes the allergies of the logged in user
			}
		}
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

    <title>Search - Restaurant A</title> <!-- change Restaurant A to whatever the user searched for -->
	
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
          <input class="form-control mr-sm-2" type="text" value="Restaurant A" aria-label="Search">
          <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>
	</div>
	
    <div class="container-fluid" id="pos">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-5 mb-1 text-muted">
              <span>Filters</span>
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item px-3">
                <p class="nav-link">
                  Sort By
                </p>
				<p>
				<fieldset class="form-group" id="sort">
					<div class="row">
						<div class="col-sm-10">
						<div class="form-check">
							<input class="form-check-input" type="radio" name="sort" id="reviews" value="1" onchange="handleChange()">
							<label class="form-check-label" for="reviews">
								Most Reviews
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="sort" id="rating" value="2" onchange="handleChange()" checked>
							<label class="form-check-label" for="rating">
								Highest Rated
							</label>
						</div>
						</div>
					</div>
				</fieldset>

				</p>
              </li>
              <li class="nav-item px-3">
                <p class="nav-link">
                  Allergies
                </p>
				<p>
				<div class="allergyList">
					<!-- list of allergies to sort through go here (added in js) -->
				</div>
					<br/>
					<label>Add an allergy to this search:</label>
					<input type="text" id="allerg" name="allergy" list="allergies"/>
					<datalist id="allergies">
						<option>Almond</option>
						<option>Egg</option>
						<option>Fish</option>
						<option>Gluten</option>
						<option>Margarine</option>
						<option>Pine nut</option>
						<option>Soy</option>
						<option>Vegan</option>
						<option>Walnut</option>
					</datalist>
					<button class="btn btn-primary btn-sm" id="add" type="button" onclick="addAllergy()">Add</button>
				</p>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </div>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-5 px-4">

          <canvas class="my-4 chartjs-render-monitor" id="myChart" width="732" height="308" style="display: block; height: 5px; width: 586px;"></canvas>

          <h2>Search Results</h2>
		  
		  <div class="insert">
			<!-- list of restaurants goes here (implemented with js) -->
		  </div>
	  
     </main>
		
<!-- default bootstrap scripts -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		
<script type="text/javascript">
		var restaurantList0 = <?php echo json_encode($entries); ?>; //name, location, tags, restaurant id, number of reviews, avg rating
		window.onload=function(){
			//input array data
			
			element = document.querySelectorAll("div.insert");
			
			for(var i=0; i<restaurantList0.length;i++){
				var frag = create('<div class="my-3 p-3 bg-white rounded box-shadow hid"><div class="media text-muted pt-3"><p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray"><strong class="d-block text-gray-dark"><a class="text-info restaurant" style="font-size:1rem" href="#">a</a></strong><a class="text-dark city" href="#">b</a><br/><span class="num">c</span> <span class="rate">d</span></br><a class="allergy" href="#">e</a></p></div></div>');
				element[0].parentElement.insertBefore(frag,element[0].childNodes[0]);
				
			}
			handleChange();
			
			var allergy = <?php echo json_encode($allergen); ?>;
			var element = document.querySelectorAll("div.allergyList"); 
			for(var i=0;i<allergy.length;i++){
				console.log(allergy[i])
				if(document.getElementById(allergy[i])==null){
					var frag = create('<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="allergy" id="'+allergy[i]+'" onclick="sortAllergies('+allergy[i]+')"><label class="custom-control-label" for="'+allergy[i]+'" id="'+allergy[i]+'0"></label></div>');
					element[0].parentElement.insertBefore(frag,element[0].nextSibling);
					var label = document.getElementById(allergy[i]+"0"); 
					label.innerHTML = allergy[i];
				}
			}
		}
		
		function handleChange(){
			var sortBy = document.getElementsByName('sort');
			
			function CompareRatingNum(a, b){
				if(a[3]<b[3]) return 1;
				if(a[3]>b[3]) return -1;
				return 0;
			}
			
			function CompareRating(a, b){
				if(a[4]<b[4]) return 1;
				if(a[4]>b[4]) return -1;
				return 0;
			}
			
			for(var i=0;i<sortBy.length;i++){
				if(sortBy[i].checked){
					switch(sortBy[i].value){
						case "1":
							restaurantList0=restaurantList0.sort(CompareRatingNum);
							break;
						case "2":
							restaurantList0=restaurantList0.sort(CompareRating);
							break;
						default:
							break;
					}
				}
			}
			
			enterData();
		}
		
		function enterData(){
			
			var restaurants = document.getElementsByClassName("restaurant");
			var cities = document.getElementsByClassName("city");
			var ratings = document.getElementsByClassName("rate");
			var numr = document.getElementsByClassName("num");
			var allergies = document.getElementsByClassName("allergy");
			
			for(var i =0; i<restaurantList0.length;i++){
				restaurants[i].innerHTML=restaurantList0[i][0];
				console.log(restaurantList0[i][3]);
				restaurants[i].href = "reviews.php?restaurantId="+restaurantList0[i][3];
				cities[i].innerHTML=restaurantList0[i][1];
				allergies[i].innerHTML= restaurantList0[i][2];
				ratings[i].innerHTML=restaurantList0[i][4] + " Review(s)";
				numr[i].innerHTML = restaurantList0[i][5] + " Stars, ";
			}
		}
		
		function sortAllergies(allergen){
			var allergies = document.getElementsByClassName("allergy");
			var hid = document.getElementsByClassName("hid");
			
			for(var i=0;i<allergies.length;i++){
				if(allergen.checked){
					if(!allergies[i].innerHTML.toLowerCase().includes(allergen.id.toLowerCase())){
						hid[i].style.display = "none";
					}
				}else{
					hid[i].style.display = "block";
				}
				
			}
				
		}
		
		function addAllergy(){
			var allergies = document.getElementById("allerg"); //allergies datalist
			var element = document.querySelectorAll("div.allergyList"); 
			if(allergies.value != ""){
				if(document.getElementById(allergies.value)==null){
					var frag = create('<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="allergy" id="'+allergies.value+'" onclick="sortAllergies('+allergies.value+')"><label class="custom-control-label" for="'+allergies.value+'" id="'+allergies.value+'0"></label></div>');
					element[0].parentElement.insertBefore(frag,element[0].nextSibling);
					var label = document.getElementById(allergies.value+"0"); 
					label.innerHTML = allergies.value;
				}
				
			}
		}
		
		function create(htmlStr) {
			var frag = document.createDocumentFragment(),
			temp = document.createElement('div');
			temp.innerHTML = htmlStr;
			while (temp.firstChild) {
				frag.appendChild(temp.firstChild);
			}
			return frag;
		}
		
		</script>
</body>
</html>