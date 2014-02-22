<?php

	session_start();
	//store session variable
	$uid = $_SESSION['uid'];

	//check to see if a specific register link was used to get here
	if (isset($_GET['camp']))
	{
		//if so, assign the string query to variable
		$presel_camp = $_GET['camp'];
	}
	else
	{
		//if not, use this default
		$presel_camp = "Camp Coe";
	}

	//connect to the db
	$con=mysqli_connect('dbserver.engr.scu.edu', 'holson', '00000755449', 'test');

	//error checking
	if(!$con)
	{
		//alert user of error
		die("Could not connect to MySQL. Error: " . mysql_error());
	}

	//grab the number of children the user has registered
	$result = mysqli_query($con, "SELECT COUNT(*) FROM camper_info WHERE parent_id='$uid'");
	//store the result in a variable for use later
	$numChildReg = (mysqli_fetch_array($result)['COUNT(*)']);

	mysqli_close($con);

?>

<html>

<head>
<title> Registration </title>

<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script language="javascript" src="Functions.js"></script>
<script language="javascript" src="registration2.js"></script>
<link rel="stylesheet" type="text/css" href="Basic.css"/>
<link rel="stylesheet" type="text/css" href="registration.css"/>

</head>


<body onload="initialize(); setCamp('<?php echo $presel_camp; ?>'); calculateFee('<?php echo $numChildReg; ?>');">
<div class="page">
	
	<div class="Header">
	<h1>Registration</h1>	
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
			<h3>SUMMER 2014 SCHEDULE</h3>
			<table border=3 cellpadding=10>
			<tr class="taxis"><td>Camp / Week</td><td>6/1</td><td>6/8</td><td>6/15</td><td>6/22</td><td>6/29</td><td>7/6</td><td>7/13</td><td>7/20</td><td>7/27</td><td>8/3</td><td>8/10</td><td>8/17</td><td>8/24</td></tr>
			<tr><td class="taxis"><b>Camp Coe</b> ($50/week, ages 8-12)</td><td class="open"></td><td class="open"></td><td class="open"></td><td class="open"></td><td class="open"></td><td class="open"></td><td class="open"></td><td class="open"></td><td class="open"></td><td class="open"></td><td></td><td></td><td></td></tr>
			<tr><td class="taxis"><b>Camp Castle Rock</b> ($100/week, ages 8-12)</td><td></td><td></td><td class="open"></td><td class="open"></td><td></td><td class="open"></td><td class="open"></td><td class="open"></td><td class="open"></td><td></td><td></td><td></td><td class="open"></td></tr>
			<tr><td class="taxis"><b>Camp Diablo</b> ($200/week, ages 10-16)</td><td class="open"></td><td></td><td></td><td></td><td></td><td></td><td></td><td class="open"></td><td class="open"></td><td></td><td class="open"></td><td class="open"></td><td></td></tr>
			<tr><td class="taxis"><b>Camp Marin</b> ($200/week, ages 12-16)</td><td></td><td></td><td></td><td></td><td></td><td class="open"></td><td class="open"></td><td></td><td></td><td class="open"></td><td class="open"></td><td></td><td></td></tr>
			<tr><td class="taxis"><b>Camp Yosemite</b> ($200/week, ages 12-16)</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td class="open"></td><td class="open"></td><td class="open"></td><td class="open"></td><td class="open"></td></tr>
			</table>

			<p><i>A green box indicates availability at the camp for that week</i></p>

		<div id="registration">
			<h2>Register now!</h2>
			<p><i>Special offer: Get a 10% discount on your registration for EACH child already registered on your account</i></p>
	

			<div id="registrationForm">
				<form id="RegistrationForm" method='POST' action='Register.php'>
		
				<?php
					//if the user isn't logged in, let them know they have to set an account password
					if( !isset($_SESSION['uid'])){
						echo "<div id='userInfo'>";
							echo "<p><b> You appear to be a first time camper! Please either login or set a password for your new account.
										When you're done registering you'll be able to login using your email and password combination.
										Registered campers are eligible for a 15% discount in our store, and are able to give feedback through our forum!
									</b></p>";	
						echo "</div>";	
					}
				?>

				<div id='campInfo'>
					<div id="fcol3">
					<br/><br/><br/><br/><br/><br/><br/><br/>
					<?php
						//if the session isn't set, move the far right column down to accomodate
						if( !isset($_SESSION['uid'])) {
							echo "<br/><br/><br/><br/>";
						}
					?>
					<label id="agelbl" for="ageselect">Child's age*</label>
					<select name='age' tabindex="7" id="ageselect">
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					</select>

					<br/>
					
					<label id="gendlbl" for="gendselect">Child's gender*</label>
					<select name='sex' tabindex="10" id="gendselect">
					<option value="M">M</option>
					<option value="F">F</option>
					</select>
		
					<br/>

					<p id="totalfee">Total Fee: $</p>
					</div>

					<div id=fcol2>
		
					<?php
						//if the user isn't logged in, generate a password field	
						if(! isset($_SESSION['uid']))
						{
							echo "<label for='password2'>Confirm password*</label>";
							echo "<br/>";
							echo "<input id='password2' name='password2' type='password'>";
							echo "<br/>";
							echo "<br/>";
						}
					?>
					<label for="Lname">Last name*</label>
					<br/>
					<input name='Lname' tabindex="2" id="Lname" value="<?php echo $_POST['Lname']; ?>" />

					<br/>
					<br/>
					<label for="Phone">Phone number*</label>
					<br/>
					<input name='phone' tabindex="4" maxlength="10" id="Phone" value="<?php echo $_POST['phone']; ?>"/>
					
					<br/>
					<br/>
					<label for="CLname">Child's last name*</label>
					<br/>
					<input name='CLname' tabindex="6" id="CLname" value="<?php echo $_POST['CLname']; ?>"/>
					
					<br/>
					<br/>
					<label for="CGrade">Child's grade in school*</label>
					<br/>
					<input name='Cgrade' tabindex="9" maxlength="2" id="CGrade" value="<?php echo $_POST['Cgrade']; ?>"/>

					<br/>
					<br/>
					<label for="Cspec">Special Instructions</label>
					<br/>
					<input name='Cspec' tabindex="12" id="CSpec" value="<?php echo $_POST['Cspec']; ?>"/>

					<br/>
					<br/>
					<label for="weeksel">Week selection*</label>
					<br/>
					<select name='week' id="weeksel" tabindex="14">
					</select>
					
					<br/>
					<br/>
					<label for="CardName">Full name on card*</label>
					<br/>
					<input name='cardName' tabindex="16" id="CardName" value="<?php echo $_POST['cardName']; ?>"/>

					<br/>
					<br/>
					<label for="CSV">CSV*</label>
					<br/>
					<input name='CSV' tabindex="19" maxlength="3" id="CSV" value="<?php echo $_POST['CSV']; ?>"/>	
					</div>


					<div id=fcol1>

					<?php	
						//if the user isn't logged in, generate a password field
						if (! isset($_SESSION['uid']))
						{
							echo "<label for='password'>Password*</label>";
							echo "<br/>";
							echo "<input id='password' name='password1' type='password'>";
							echo "<br/>";
							echo "<br/>";
						}
					?>
					
					<label for="Fname">First name*</label>
					<br/>
					<input name='Fname' tabindex="1" id="Fname" value="<?php echo $_POST['Fname']; ?>"/>

					<br/>
					<br/>
					<label for="Email">Contact Email address*</label>
					<br/>
					<input name='email' tabindex="3" id="Email" value="<?php echo $_POST['email']; ?>"/>


					<br/>
					<br/>
					<label for="CFname">Child's first name*</label>
					<br/>
					<input name='CFname' tabindex="5" id="CFname" value="<?php echo $_POST['CFname']; ?>"/>

					<br/>
					<br/>
					<label for="CSchool">Child's school*</label>
					<br/>
					<input name='school' tabindex="8" id="CSchool" value="<?php echo $_POST['school']; ?>"/>

					<br/>
					<br/>
					<label for="aller">Any allergies?</label>
					<br/>
					<input name='aller' tabindex="11" id="aller" value="<?php echo $_POST['aller']; ?>"/>

					<br/>
					<br/>
					<label for="campsel">Camp selection*</label>
					<br/>
					<select name='camp' tabindex="13" id="campsel" onchange="updateWeek(); calculateFee(<?php echo $numChildReg; ?>)">
					<option value="Camp Coe">Camp Coe</option>
					<option value="Camp Castle Rock">Camp Castle Rock</option>
					<option value="Camp Diablo">Camp Diablo</option>
					<option value="Camp Marin">Camp Marin</option>
					<option value="Camp Yosemite">Camp Yosemite</option>
					<select>	

					<br/>
					<br/>
					<label for="Ccard">Credit card number*</label>
					<br/>
					<input name='Ccard' tabindex="15" maxlength="16" id="Ccard" value="<?php echo $_POST['Ccard']; ?>"/>

					<br/>
					<br/>
					<label for="expmonth">Exp Month*/</label>
					<label for="expyear">Year*</label>
					<br/>
					<input name='expM' tabindex="17" maxlength="2" id="expmonth" value="<?php echo $_POST['expM']; ?>"/>
					<span>/</span>
					<input name='expY' tabindex="18" maxlength="4" id="expyear" value="<?php echo $_POST['expY']; ?>"/>
					
					</div>


					<input tabindex="20" id="regsubmit" type="submit" onclick="" value="Register"/>
				</div>
				</form>
				<div id="errdisp">
					<?php
						//require the function file
						require('RegCheck.php');

						//only call the function if post data was sent
						if($_SERVER['REQUEST_METHOD'] == 'POST')
						{	
							//if the user is logged in, check their form with one function
							if(isset($_SESSION['uid']))
							{
								checkReg();
							}
							else
							{
								//check with another
								checkRegNewUser();
							}
						}

						if(isset($_SESSION['message']))
						{
							echo $_SESSION['message'];
							unset($_SESSION['message']);
						}	
					?>
				</div>

			</div>
		</div>
			<div id='currentCampers' >
				<h3> Current campers you have registered </h3>
				<?php
					if(isset($_SESSION['uid'])){
						$link = mysqli_connect('dbserver.engr.scu.edu','holson','00000755449','test');
						$q = $link->prepare("SELECT * FROM camper_info WHERE parent_id=?");
						$q->bind_param('i',$_SESSION['uid']);
						$q->execute();
						$campers = $q->get_result();
					
						$oneCamper = mysqli_fetch_row($campers);
						echo "<table>";
						echo "<tbody>";
							echo "<tr>";
								echo "<th> Camper Name </th>";
								echo "<th> Camp </th>";
								echo "<th> Week </th>";
							echo "</tr>";

						while( $oneCamper != null ){											
							echo "<tr>";
								echo "<td>";
									echo $oneCamper[5];
								echo "</td>";
								echo "<td>";
									echo $oneCamper[2];
								echo "</td>";
								echo "<td>";
									echo $oneCamper[9];
								echo "</td>";
							echo "</tr>";
							$oneCamper = mysqli_fetch_row($campers);
						}		
							echo "</tbody>";
							echo "</table>";
						mysqli_close($link);
					}
				?>
			


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
