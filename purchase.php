
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
			<form action="javascript:loadRecipt()">
				<div id="orderInfo">
					<?php loadCheckout(); 
					 ?>
				</div>
				<input type="submit" value="Place Order"/>
				<div>
				<table>
				<tbody>

				<tr class="formBreak">
					<td colspan="6">
						<h4> Mailing Information</h4>
					</td>
				</tr>

				<tr>
					<td> 
						<label for="fName">First Name </label>
					</td>
					<td>
						<input id="fName" type="text"/>
					</td>
					<td>
						<label for="lName">Last Name </label>
					</td>
					<td colspan="2" >
						<input id="lName" type="text"/>	
					</td>
				</tr>


				<tr>
					<td>	
						<label for="State"> State </label>
					</td>
					<td>
					<select id="State" height="4">

							<option value="AL">AL</option>
							<option value="AK">AK</option>
							<option value="AZ">AZ</option>
							<option value="AR">AR</option>
							<option value="CA">CA</option>
							<option value="CO">CO</option>
							<option value="CT">CT</option>
							<option value="DE">DE</option>
							<option value="FL">FL</option>

							<option value="GA">GA</option>
							<option value="HI">HI</option>
							<option value="ID">ID</option>
							<option value="IL">IL</option>
							<option value="IN">IN</option>
							<option value="IA">IA</option>
							<option value="KS">KS</option>
							<option value="KY">KY</option>
							<option value="LA">LA</option>
							<option value="ME">ME</option>

							<option value="MD">MD</option>
							<option value="MA">MA</option>
							<option value="MI">MI</option>
							<option value="MN">MN</option>
							<option value="MS">MS</option>
							<option value="MO">MO</option>
							<option value="MT">MT</option>
							<option value="NE">NE</option>
							<option value="NV">NV</option>
							<option value=NH"">NH</option>

							<option value="NJ">NJ</option>
							<option value="NM">NM</option>
							<option value="NY">NY</option>
							<option value="NC">NC</option>
							<option value="ND">ND</option>
							<option value="OH">OH</option>
							<option value="OK">OK</option>
							<option value="OR">OR</option>
							<option value="PA">PA</option>
							<option value="RI">RI</option>

							<option value="SC">SC</option>
							<option value="SD">SD</option>
							<option value="TN">TN</option>
							<option value="TX">TX</option>
							<option value="UT">UT</option>
							<option value="VT">VT</option>
							<option value="VA">VA</option>
							<option value="WA">WA</option>
							<option value="WV">WV</option>
							<option value="WI">WI</option>
							<option value="WY">WY</option>

						</select>
					</td>
					<td>
						<label for="city">City</label>
					</td>
					<td>
						<input id="city" type="text"/>
					</td>
					<td>
						<label for="adr">Address</label>
					</td>
					<td>
						<input id="adr" type="text"/>
					</td>
				</tr>

				<tr class="formBreak">
					<td colspan="6">
						<h4> Card Information </h4>
					</td>
				</tr>

				<tr>
					<td>
						<label for="cardType"> Card Type </label>
					</td>
					<td>
						<select id="cartType">
							<option value="MC">Master Card</option>
							<option value="V">Visa</option>
							<option value="AE">American Express</option>
							<option value="D">Discover</option>
						</select>
					</td>
					<td>
						<label for="cardNum">Card Number</label>
					</td>
					<td>						
						<input id="cardNum" type="text"></label>
					</td>
					<td>
						<label for="expD"> Experation </label>
					</td>
					<td>
						<input style="width:20px;"  maxlength="2"/>
						<input  style="width:40px;"  maxlength="4"/>

					</td>
				</tr>

				</tbody>		
				</table>
		
				</div>
			</form>
		</div>

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
