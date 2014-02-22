<?php
	session_start();
?>
<html>

<head>
<title> Game </title>

<!--Link JQuery-->
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

<!--Link our functions-->
<script language="javascript" src="Functions.js"></script>

<script src="game.js" type="text/javascript"></script>

<!--Link CSS stylesheet-->
<link rel="stylesheet" type="text/css" href="Basic.css"/>
<link rel="stylesheet" type="text/css" href="game.css"/>

</head>


<body onload="initialize(); GameManager();">
<div class="page">
	
	<div class="Header">
		<h1>Catch the Leaf!</h1>	
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

		<div id="gameArea">
			<div id="gameControl" >
				<h1> Game Mode </h1>
				<p> Click the leaf before it disappears! </p>
				<input id='selectG1' type='Button'  value="Play"/>
			</div>
		</div>
<!--	<canvas id="canvas" height="500px" width="700px"> get a better browser! </canvas>	-->
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
</body>
</html>
