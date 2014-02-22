<?php
	session_start();
?>
<html>

<head>
<title> Camper Home </title>

<!--Link JQuery-->
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

<!--Link our functions-->
<script language="javascript" src="Functions.js"></script>

<!--Link Google Maps API-->
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>

<!--Link Map Location-->
<script src="locations.js" type="text/javascript"></script>

<!--Link CSS stylesheet-->
<link rel="stylesheet" type="text/css" href="Basic.css"/>
<link rel="stylesheet" type="text/css" href="index.css"/>

</head>


<body onload="initialize()">
<div class="page">
	
	<div class="Header">
		<h1>Camp Nature Life</h1>	
		<?php
			//check to see if a session variable is set
			if(!empty($_SESSION['uid']))
			{
				echo "<p id=\"greeting\">signed in as &nbsp;<b>" . $_SESSION['email'] . "</b></p>";
			}
		?>	
	</div>
	
	<div class="NavBar">
	<!--	LOAD LINKS TO OTHER PAGES	-->
	</div>

	<div class="Content">

		<img id="mainpic" src="Images/camp.jpg" alt="2013 Camp Marin">

		<h2 id="subtitle">View our camp locations for Summer 2014 now!</h2>

		<aside>
			<h3 id="campname">Choose a camp location on the map!</h3>
			<p id="campdesc"></p>
			<p id="actheader"></p>
			<ul id="activities"></ul>
			<p id="campages"></p>
			<p id="weeks"></p>
			<p id="camploc"></p>
			<form id="reg"></form>
		</aside>
			
		<div id="map-canvas">
		</div>

		<div id="testimonial">
			<img src="Images/parent.jpg" alt="A happy camper parent">
			<p>"My daughter loves Camp Nature Life so much that she's begged me to sign her up three years in a row! The crafts she comes home with are wonderful." </p>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Mindy Tamriel, parent</p>
		</div>
		<p><i>Nature Life Camps is committed to providing memorable and educational experiences to campers of all ages. Our mission is to foster a greater respect for nature by demonstrating its beauty and diversity to younger generations.</i></p> 
	</div>

	<hr>

	<footer>
		<address>
			Henry Olson - holson@scu.edu
			<br>
			Nick Dario - ndario@scu.edu
		</address>
	</footer>


</div>
	<script type="text/javascript">

		//initialize the google map
		var map = new google.maps.Map(document.getElementById('map-canvas'), {
			zoom: 7,
			minZoom:7,
			center: new google.maps.LatLng(37.567059, -121.291504),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});

		//initialize the info window
		var infowindow = new google.maps.InfoWindow();

		var marker;
		var i;

		//create and initialize the map markers
		for (i=0; i<locations.length; i++) {
			//create a marker on the map for each location as defined in locations.js
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(locations[i][1], locations[i][2]),
				map: map
				});

			//add event listeners to each marker
			google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
				//when clicked on, each location will have a pop-up showing the location name
				infowindow.setContent(locations[i][0]);
				infowindow.open(map, marker);
				//when clicked, call the function to draw the question
				campInfoDisplay(locations[i][0]);
				}
			})(marker, i));
		}

	</script>	
</body>
</html>
