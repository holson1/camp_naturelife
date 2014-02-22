<html>

<head>
<title> Feedback </title>

<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script language="javascript" src="Functions.js"></script>
<script language="javascript" src="Feedback.js"></script>
<link rel="stylesheet" type="text/css" href="Basic.css"/>
<link rel="stylesheet" type="text/css" href="feedback.css"/>

</head>

<?php include "./PHP/FeedbackFunctions.php"; ?>


<body onload="initialize()">
<div class="page">
	
	<div class="Header">
		<h1>Feedback</h1>	
		<?php
			if(isset($_SESSION['uid']))
				echo "<p id=\"greeting\">signed in as &nbsp;<b>" . $_SESSION['email'] . "</b></p>";
		?>
	</div>
	
	<div class="NavBar">
	<!--	LOAD LINKS TO OTHER PAGES	-->
	</div>

	<div class="Content">
		<div id='FeedbackForm'>
			<?php loadFeedbackForm(); ?>
		</div>
		<div id='FeedbackDisplay'>
			<?php loadFeedbackDisplay(); ?>
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
