<?php
session_start();

if( isset($_SESSION['cart'])){
	unset($_SESSION['cart']);
}

?>

<html>
<head>
<title>Login</title>

<!--Link JQuery-->
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>

<!--Link our functions-->
<script language="javascript" src="Functions.js"></script>


<link rel="stylesheet" type="text/css" href="Basic.css"/>
</head>

<body onload="initialize()">
	<div class="page">
	
		<div class="Header">
			<h1>Login</h1>	
		</div>
	
		<div class="NavBar">
		<!--	LOAD LINKS TO OTHER PAGES	-->
		</div>

		<div class="Content">

<?php
	//check to see if data was sent
	if( !$_POST['logEmail'] || !$_POST['logPW'] )
	{	
		//if not, alert the user
		echo "<script> showLogin(); </script>";
		die("<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><h3>Login failed, please fill in both fields.</h3>");
	}
	
	//data was sent in both fields, so let's assign it to some new vars
	$logEmail = $_POST['logEmail'];
        $logPW = $_POST['logPW'];

	//connect to the db
	$con = mysqli_connect('dbserver.engr.scu.edu', 'holson', '00000755449', 'test');

	//test connection
	if( !$con )
	{
		die("Error: could not connect to MySQL database");
	}	

	//prepare the statement
	$q = $con->prepare('SELECT * FROM user_info WHERE email=? AND password=?');
	$q->bind_param('ss', $logEmail, $logPW);
	//execute
	$q->execute();

	//grab result and loop through
	$result = $q->get_result();
	
	//get the number of results
	$num_results = mysqli_num_rows($result);
	//if this number is 0, the info doesn't match 
	if($num_results == 0)
	{
		echo "<script> showLogin(); </script>";
		die("<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><h3>Login failed, email and/or password don't match our records.</h3>");
	}

	//get the row	
	$row = mysqli_fetch_array($result);

	//store the user id field in a session variable
	$_SESSION['uid']=$row[0];
	//and the email as well
	$_SESSION['email']=$row[1];

	mysqli_close($con);

	echo "<h3>You have successfully logged in as: " . $_SESSION['email'] . "</h3>";
	echo "<a href=\"index.php\">Return to home</a>";

	if( $_GET["page"] == 'login.php'){
		//redirect to the home page
		header('Location: index.php');
	}else{
		header('Location:'.$_GET["page"]);
	}
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
