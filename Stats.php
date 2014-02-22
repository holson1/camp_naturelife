<html>

<head>
<title> Camp Statistics </title>

<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script language="javascript" src="Functions.js"></script>
<script language="javascript" src="stats.js"></script>
<script language="javascript" src="locations.js"></script>
<link rel="stylesheet" type="text/css" href="Basic.css"/>
<link rel="stylesheet" type="text/css" href="stats.css"/>

</head>

<?php session_start() ?>

<body onload="initialize()">
<div class="page">
	
	<div class="Header">
		<h1>Camp Statistics</h1>	
		<?php
			if( isset($_SESSION['uid'])) 
				echo "<p id=\"greeting\">signed in as &nbsp;<b>" . $_SESSION['email'] . "</b></p>";
		?>
	</div>
	
	<div class="NavBar">
	<!--	LOAD LINKS TO OTHER PAGES	-->
	</div>

	<div class="Content">
		<div id="statsBoard">
			<?php include "./PHP/StatsFunctions.php"; ?>
		</div>

		<div id="statsBottom" >

			<div id="statsInfo">
				<form id="statsCtrl">
					<label for="statSelector">Statistic</label>
					<select onchange="statsSelection(this)">
						<option value="byCamp" name="byCamp" >Registration By Camp!</option>
						<option value="byAge" name="byAge" >Registration By Age!</option>
					</select>
				</form>
				<div id="statsDescription">
					<h3> Campers Per Camp </h3>
					<p>
						Above you can look at whihc camps are more popular and which are less. All of Camp Nature Life's locations are wonderful experiences.
					</p>
				</div>

			</div>

		</div>

	</div>

	<hr>

	<footer>
		<address>
			Henry Olsen - holsen@scu.edu

			<br>
			Nick Dario - ndario@scu.edu
		</address>
	</footer>


</div>
</body>
</html>
