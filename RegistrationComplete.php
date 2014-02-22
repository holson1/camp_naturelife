<html>

<head>
<title> Welcome to Nature Life! </title>

<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script language="javascript" src="Functions.js"></script>
<link rel="stylesheet" type="text/css" href="Basic.css"/>
<link rel="stylesheet" type="text/css" href="registration.css"/>

</head>


<body onload="initialize(); setCamp('<?php echo $presel_camp; ?>'); calculateFee('<?php echo $numChildReg; ?>');">
<div class="page">
	
	<div class="Header">
	<h1>Welcome to Nature Life!</h1>	
	<?php			
		if( isset($_SESSION['uid'])){
			echo "<p id=\"greeting\">signed in as &nbsp;<b>" . $_SESSION['email'] . "</b></p>";
		}
	?>
	</div>
	
	<div class="NavBar">
	<!--	LOAD LINKS TO OTHER PAGES	-->
	</div>

	<div class="Content">

		<?php
			
		// Display MySQL data using current $_SESSION[uid]
	
		?>

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
