
<html>

<head xmlns="http://www.w3.org/1999/xhtml">
<title> Checkout </title>

<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script language="javascript" src="Functions.js"></script>
<script language="javascript" src="store.js"></script>
<link rel="stylesheet" type="text/css" href="Basic.css"/>
<link rel="stylesheet" type="text/css" href="store.css"/>


</head>

<?php 
	include './PHP/StoreFunctions.php';
?>


<body onload="initialize()">
<div class="page">
	
	<div class="Header">
		<h1>Checkout</h1>
		<?php
			if(isset($_SESSION['uid']))
				echo "<p id=\"greeting\">signed in as &nbsp;<b>" . $_SESSION['email'] . "</b></p>"; 
		?>

	</div>
	
	<div class="NavBar">
	<!--	LOAD LINKS TO OTHER PAGES	-->
	</div>

	<div class="Content">

		<div id="Checkout">
			<form action="checkout.php">
				<div id="orderInfo">
					<?php loadRecipt(); ?>
				</div>
				<input type="submit" value="Place Order" />
			</form>
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
