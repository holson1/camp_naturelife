
<html>

<head xmlns="http://www.w3.org/1999/xhtml">
<title> Camper Store </title>

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
		<h1>Camper Store</h1>
		<?php
			if(isset($_SESSION['uid']))
				echo "<p id=\"greeting\">signed in as &nbsp;<b>" . $_SESSION['email'] . "</b></p>"; 
		?>
	</div>
	
	<div class="NavBar">
	<!--	LOAD LINKS TO OTHER PAGES	-->
	</div>

	<div class="Content">
	<div id="Decoration">
	</div>
		<div id="notifications">
			<h3> Happy Holidays! </h3>
			<p> Its the time of year where things start smelling like cinnamon, and people start wearing ugly sweaters because being cozy is worth it! Celebrate the season with our special limited time KidsCamp Sweatshirts and have the coolest kid on the playground or be the envy of the poser parents.</p>
		</div>

		<aside id="cart">
				<embed id="cartImage" src="Images/cart.svg"/>
				<!-- <embed id="cartImageIcon" src="Images/cartIcon.svg"/> -->
				<h3> Cart </h3>
				<table id="cartContents">
				<tbody>
					<?php
						loadCart();
					?>
				</tbody>
				</table>
				<div id="cartStickerHolder">
					<?php
						echo makeCartSticker(getTotalItems());
					?>
				</div>
		</aside>


		<div id="store">
			<?php
//				loadStore('csv');
				loadStore('mysql');
			?>
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
